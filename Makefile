# —— Inspired by ———————————————————————————————————————————————————————————————
# https://www.strangebuzz.com/fr/snippets/le-makefile-parfait-pour-symfony
# who was inspired by
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/


# —— Setup ————————————————————————————————————————————————————————————————————————
DC             = docker-compose
PROJECT_DIR    = /glsr
RUN            = $(DC) run --rm
RUN_SERVER     = $(RUN) -w $(PROJECT_DIR)/server
EXEC           = $(DC) exec
SERVER_CONSOLE = $(EXEC) php php server/bin/console
GIT_AUTHOR     = Dev-Int
PASS_PHRASE?   = glsr
VERSION?       =

.DEFAULT_GOAL :=help
.PHONY: help start stop build up reset cc install security config

check_defined = \
    $(strip $(foreach 1,$1, \
        $(call __check_defined,$1,$(strip $(value 2)))))
__check_defined = \
    $(if $(value $1),, \
        $(error Undefined $1$(if $2, ($2))$(if $(value @), \
                required by target `$@')))


## —— The Glsr Makefile ———————————————————————————————————————————————

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


## —— Composer —————————————————————————————————————————————————————————————————

update: server/composer.json ## Update vendors according to the composer.json file
	@echo "Update php dependencies"
	@$(RUN_SERVER) php php -d memory_limit=-1 /usr/local/bin/composer update --no-interaction


## —— Project —————————————————————————————————————————————————————————————————————

start: config build project-vendors up #db-test ## Install and start the project

stop: ## Remove docker containers
	@echo "Stopping containers"
	@$(DC) kill > /dev/null
	@$(DC) rm -v --force > /dev/null
	@echo "Container stopped"

reset: stop start ## Reset the whole project

install: start security ## Install the whole project

cc: ## Clear the cache in dev env
	@rm -rf server/var/cache/*
	@$(EXEC) php php -d memory_limit=-1 server/bin/console cache:warmup

clean-dir: ## Clean directories
	@rm -rf server/var/cache/* \
			server/var/logs/*

clear: cc clean-dir ## Remove all the cache, the logs, the sessions

security:
	@mkdir -p server/config/jwt/
	@$(EXEC) php openssl genrsa -aes256 -passout pass:$(PASS_PHRASE) -out server/config/jwt/private.pem 4096
	@$(EXEC) php openssl rsa -pubout -in server/config/jwt/private.pem -passin pass:$(PASS_PHRASE) -out server/config/jwt/public.pem

config: server/.env.local docker-compose.override.yml dist-files .git/hooks/pre-commit ## Init files required
	@echo 'Configuration files copied'

bash-php: ## Open bash in php container
	@$(EXEC) php bash

bash-client: ## Open bash in client container
	@$(EXEC) client bash


## —— DB ——————————————————————————————————————————————————————————————————————————

db-test: server/.env.test ## Create tests database
	@echo "create database for tests"
	@$(SERVER_CONSOLE) doctrine:database:create --env=test

db-diff: ## Generation doctrine diff
	@$(SERVER_CONSOLE) doctrine:migrations:diff --namespace 'Core\Infrastructure\DoctrineMigrations'
	@$(SERVER_CONSOLE) doctrine:migrations:diff --namespace 'Administration\Infrastructure\DoctrineMigrations'

db-migrate: ## Launch doctrine migrations
	@$(SERVER_CONSOLE) doctrine:migrations:migrate --no-interaction

db-reset: ## Reset database with given DUMP variable
	@:$(call check_defined, DUMP, sql file)
	@echo 'Reseting database'
	@$(EXEC) mysql reset $(DUMP) > /dev/null

db-save: ## Save database to a sql file
	@:$(call check_defined, DUMP, sql file)
	@echo 'Saving database'
	@$(EXEC) mysql save $(DUMP) > /dev/null

reload: load-fixtures ## Reload fixtures

load-fixtures: ## Build the DB, load fixtures
	@echo ""
	$(SERVER_CONSOLE) doctrine:cache:clear-metadata
	$(SERVER_CONSOLE) doctrine:database:create --if-not-exists
	$(SERVER_CONSOLE) doctrine:fixtures:load -n


## —— Tests ———————————————————————————————————————————————————————————————————————

test-all: test-cc server/phpunit.xml ## Execute tests
	@echo 'Running all tests'
	@echo '—— Unit tests ——'
	@$(EXEC) -w /glsr/server php php -d memory_limit=-1 bin/phpunit --stop-on-failure

test-domain: server/phpunit.xml test-cc ## Launch Domain unit tests
	@echo "Running unit Domain tests"
	@$(EXEC) -w /glsr/server php php -d memory_limit=-1 bin/phpunit --testsuite=Domain --stop-on-failure

test-e2e: server/phpunit.xml test-cc ## Launch End2End tests
	@echo "Running end to end tests"
	@$(EXEC) -w /glsr/server php php -d memory_limit=-1 bin/phpunit --testsuite=End2End --stop-on-failure

test-coverage: clean-dir  ## Run test coverage
	@echo 'Running tests coverage'
	@$(EXEC) -w /glsr/server php php -d memory_limit=-1 bin/phpunit --coverage-html=var/test-coverage/

test-cc: ## Clear the cache in test environment. DID YOU CLEAR YOUR CACHE????
	$(SERVER_CONSOLE) c:c --env=test


## —— Coding standards ✨ ———————————————————————————————————————————————————————

cs: codesniffer stan #lint ## Launch check style and static analysis

codesniffer: ## Run php_codesniffer only
	@$(EXEC) php server/vendor/squizlabs/php_codesniffer/bin/phpcs --standard=server/phpcs.xml -n -p server/src/

stan: ## Execute phpstan
	@$(EXEC) php server/vendor/bin/phpstan analyze -c server/phpstan.neon

cs-fixer: ## Execute php-cs-fixer
	@$(EXEC) php server/vendor/bin/php-cs-fixer fix --config server/.php_cs

#psalm: ## Run psalm only
#	@$(EXEC) php vendor/bin/psalm --show-info=false
#
#init-psalm: ## Init a new psalm config file for a given level, it must be decremented to have stricter rules
#	@rm ./psalm.xml
#	@$(EXEC) php vendor/bin/psalm --init src/ 3

version: ## Add a new tag with current date and publish it
	@git checkout main > /dev/null
	@git fetch --tags && git pull
	@echo "MEP $(shell date '+%Y.%m.%d')\n" > VERSION
	@git log --graph --pretty='%s' $(shell git tag | sort -r | head -n 1)..main >> VERSION
	@git tag -a $(shell date '+%Y.%m.%d') -F VERSION > /dev/null
	@git push --tags > /dev/null
	@rm VERSION


# ## —— Deploy & Prod ————————————————————————————————————————————————————————————
#deploy: ## Full no-downtime deployment with EasyDeploy
#	$(SERVER_CONSOLE) deploy -v
#
#env-check: ## Check the main ENV variables of the project
#	printenv | grep -i app_
#
#le-renew: ## Renew Let's Encrypt HTTPS certificates
#	certbot --apache -d demo.glsr.fr


# —— Yarn / JavaScript ————————————————————————————————————————————————————————
#dev: ## Rebuild assets for the dev env
#	yarn install
#	yarn run encore dev
#
#watch: ## Watch files and build assets when needed for the dev env
#	yarn run encore dev --watch
#
#build: ## Build assets for production
#	yarn run build

lint: ## Run TSLint on client
	@$(EXEC) client yarn run lint


## Dependencies ————————————————————————————————————————————————————————————————

# Internal rules
project-vendors: server/vendor client/node_modules ## Server vendors
	@echo "Vendors installed"

build:
	@echo "Building images"
	@$(DC) build > /dev/null

up:
	@echo "Starting containers"
	@$(DC) up -d --remove-orphans


# Single file dependencies
.env.local: server/.env
	@echo "Copying docker environment variables"
	@cp .env .env.local
	@sed -i "s/^APP_USER_ID=.*/APP_USER_ID=$(shell id -u)/" .env.local
	@sed -i "s/^APP_GROUP_ID=.*/APP_GROUP_ID=$(shell id -g)/" .env.local
.git/hooks/pre-commit: .docker/git/pre-commit
	@echo "Copying git hooks"
	@cp .docker/git/pre-commit .git/hooks/pre-commit
	@chmod +x .git/hooks/pre-commit
docker-compose.override.yml: docker-compose.override.yml.dist
	@echo "Copying docker configuration"
	@cp docker-compose.override.yml.dist docker-compose.override.yml
server/vendor: server/composer.lock
	@echo "Installing project dependencies"
	@$(RUN_SERVER) php php -d memory_limit=-1 /usr/local/bin/composer install --no-interaction
dist-files: server/.php_cs.dist
	@echo "Coping .dist files"
	@cp server/.php_cs.dist server/.php_cs
client/node_modules: client/yarn.lock
	@echo "Installing client dependencies"
	@$(RUN) client yarn install


## —— Stats ————————————————————————————————————————————————————————————————————
stats: ## Commits by the hour for the main author of this project
	@git log --author="$(GIT_AUTHOR)" --date=iso | perl -nalE 'if (/^Date:\s+[\d-]{10}\s(\d{2})/) { say $$1+0 }' | sort | uniq -c|perl -MList::Util=max -nalE '$$h{$$F[1]} = $$F[0]; }{ $$m = max values %h; foreach (0..23) { $$h{$$_} = 0 if not exists $$h{$$_} } foreach (sort {$$a <=> $$b } keys %h) { say sprintf "%02d - %4d %s", $$_, $$h{$$_}, "*"x ($$h{$$_} / $$m * 50); }'
