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

install: start ## Install the whole project

config: .env.local ## Init files required
	@echo 'Configuration files copied'


## —— Tests ———————————————————————————————————————————————————————————————————————

test-all: test-unit test-behat  ## Execute tests
	@echo 'Running all tests'

test-unit: phpunit.xml.dist ## Execute unit tests
	@echo '—— Unit tests ——'
	@$(EXEC) -w /glsr php php -d memory_limit=-1 vendor/bin/phpunit --stop-on-failure
test-behat: behat.yaml.dist ## Execute behat tests
	@echo '—— Behat tests ——'
	@$(EXEC) -w /glsr php php vendor/bin/behat


## Dependencies ————————————————————————————————————————————————————————————————

# Internal rules
project-vendors: vendor #client/node_modules ## Server vendors
	@echo "Vendors installed"

build:
	@echo "Building images"
	@$(DC) build > /dev/null

up:
	@echo "Starting containers"
	@$(DC) up -d --remove-orphans


# Single file dependencies
.env.local: .env
	@echo "Copying docker environment variables"
	@cp .env .env.local
	@sed -i "s/^APP_USER_ID=.*/APP_USER_ID=$(shell id -u)/" .env.local
	@sed -i "s/^APP_GROUP_ID=.*/APP_GROUP_ID=$(shell id -g)/" .env.local
vendor: composer.lock
	@echo "Installing project dependencies"
	@$(RUN_SERVER) php php -d memory_limit=-1 /usr/local/bin/composer install --no-interaction
