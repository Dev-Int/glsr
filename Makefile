# —— Inspired by ———————————————————————————————————————————————————————————————
# https://www.strangebuzz.com/fr/snippets/le-makefile-parfait-pour-symfony
# who was inspired by
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/


# Setup ————————————————————————————————————————————————————————————————————————
EXEC_PHP      = php
GIT           = git
GIT_AUTHOR    = Dev-Int
SYMFONY       = $(EXEC_PHP) bin/console
SYMFONY_BIN   = symfony
COMPOSER      = composer
.DEFAULT_GOAL = help


## —— The Tests Symfony Makefile ———————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

wait: ## Sleep 5 seconds
	sleep 5


## —— Composer —————————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	$(COMPOSER) install --no-progress --no-suggest --prefer-dist --optimize-autoloader

update: composer.json ## Update vendors according to the composer.json file
	$(COMPOSER) update


## —— Symfony ——————————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	$(SYMFONY) c:c

warmup: ## Warmup the cache
	$(SYMFONY) cache:warmup

fix-perms: ## Fix permissions of all var files
	chmod -R 777 var/*

assets: purge ## Install the assets with symlinks in the public folder
	$(SYMFONY) assets:install public/ --symlink --relative

purge: ## Purge cache and logs
	rm -rf var/cache/* var/logs/*


## —— Symfony binary ———————————————————————————————————————————————————————————
bin-install: ## Download and install the binary in the project (file is ignored)
	curl -sS https://get.symfony.com/cli/installer | bash
	mv ~/.symfony/bin/symfony .

cert-install: ## Install the local HTTPS certificates
	$(SYMFONY_BIN) server:ca:install

serve: ## Serve the application with HTTPS support
	$(SYMFONY_BIN) serve --daemon --port=8000

unserve: ## Stop the webserver
	$(SYMFONY_BIN) server:stop


## —— Project ——————————————————————————————————————————————————————————————————
reload: load-fixtures ## Reload fixtures

load-fixtures: ## Build the DB, control the schema validity, load fixtures and check the migration status
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:schema:drop --force
	$(SYMFONY) doctrine:schema:create
	$(SYMFONY) doctrine:schema:validate
	$(SYMFONY) doctrine:fixtures:load -n


## —— Tests ————————————————————————————————————————————————————————————————————
test: phpunit.xml ## Launch main functional and unit tests
	./vendor/bin/phpunit --testsuite=main --stop-on-failure

test-external: phpunit.xml ## Launch tests implying external resources (API, services...)
	./vendor/bin/phpunit --testsuite=external --stop-on-failure

test-all: phpunit.xml ## Launch all tests
	./vendor/bin/phpunit --stop-on-failure


## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: codesniffer stan lint ## Launch check style and static analysis

codesniffer: ## Run php_codesniffer only
	./vendor/squizlabs/php_codesniffer/bin/phpcs --standard=phpcs.xml -n -p src/

stan: ## Run PHPStan only
	./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit 1G

psalm: ## Run psalm only
	./vendor/bin/psalm --show-info=false

init-psalm: ## Init a new psalm config file for a given level, it must be decremented to have stricter rules
	rm ./psalm.xml
	./vendor/bin/psalm --init src/ 3

cs-fix: ## Run php-cs-fixer and fix the code.
	./vendor/bin/php-cs-fixer fix


## —— Deploy & Prod ————————————————————————————————————————————————————————————
#deploy: ## Full no-downtime deployment with EasyDeploy
#	$(SYMFONY) deploy -v
#
#env-check: ## Check the main ENV variables of the project
#	printenv | grep -i app_
#
#le-renew: ## Renew Let's Encrypt HTTPS certificates
#	certbot --apache -d strangebuzz.com -d www.strangebuzz.com


## —— Yarn / JavaScript ————————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	yarn install
	yarn run encore dev

watch: ## Watch files and build assets when needed for the dev env
	yarn run encore dev --watch

build: ## Build assets for production
	yarn run encore production

lint: ## Lints Js files
	npx eslint assets/js --fix


## —— Stats ————————————————————————————————————————————————————————————————————
stats: ## Commits by the hour for the main author of this project
	$(GIT) log --author="$(GIT_AUTHOR)" --date=iso | perl -nalE 'if (/^Date:\s+[\d-]{10}\s(\d{2})/) { say $$1+0 }' | sort | uniq -c|perl -MList::Util=max -nalE '$$h{$$F[1]} = $$F[0]; }{ $$m = max values %h; foreach (0..23) { $$h{$$_} = 0 if not exists $$h{$$_} } foreach (sort {$$a <=> $$b } keys %h) { say sprintf "%02d - %4d %s", $$_, $$h{$$_}, "*"x ($$h{$$_} / $$m * 50); }'
