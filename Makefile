current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps start

.PHONY: deps
deps: composer-install

# 🐘 Composer
composer-env-file:
	@if [ ! -f .env.local ]; then echo '' > .env.local; fi

.PHONY: composer-install
composer-install: CMD=install

.PHONY: composer-update
composer-update: CMD=update

.PHONY: composer-require
composer-require: CMD=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: CMD=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

.PHONY: composer
composer composer-install composer-update composer-require composer-require-module: composer-env-file
	@docker run --rm $(INTERACTIVE) --volume $(current-dir):/app --user $(id -u):$(id -g) \
		composer:2.3.7 $(CMD) \
			--ignore-platform-reqs \
			--no-ansi

.PHONY: reload
reload: composer-env-file
	@docker-compose exec php-fpm kill -USR2 1
	@docker-compose exec nginx nginx -s reload

.PHONY: test
test: composer-env-file
	docker exec librarify-php_ddd_backend-php ./vendor/bin/phpunit --testsuite librarify
	docker exec librarify-php_ddd_backend-php ./vendor/bin/phpunit --testsuite shared
	docker exec librarify-php_ddd_backend-php ./vendor/bin/behat -p librarify_backend --format=progress -v
	docker exec librarify-php_ddd-backoffice_backend-php ./vendor/bin/phpunit --testsuite backoffice

.PHONY: static-analysis
static-analysis: composer-env-file
	docker exec librarify-php_ddd_backend-php ./vendor/bin/psalm

.PHONY: lint
lint:
	docker exec librarify-php_ddd_backend-php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --allow-risky=yes --dry-run

.PHONY: run-tests
run-tests: composer-env-file
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite backoffice
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite librarify
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite shared
	./vendor/bin/behat -p librarify_backend --format=progress -v

# 🐳 Docker Compose
.PHONY: start
start: CMD=up --build -d

.PHONY: stop
stop: CMD=stop

.PHONY: destroy
destroy: CMD=down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
.PHONY: doco
doco start stop destroy: composer-env-file
	UID=${shell id -u} GID=${shell id -g} docker-compose $(CMD)

.PHONY: rebuild
rebuild: composer-env-file
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

.PHONY: ping-mysql
ping-mysql:
	@docker exec librarify-php_ddd-mysql mysqladmin --user=root --password= --host "127.0.0.1" ping --silent

.PHONY: ping-elasticsearch
ping-elasticsearch:
	@curl -I -XHEAD localhost:9200

.PHONY: ping-rabbitmq
ping-rabbitmq:
	@docker exec librarify-php_ddd-rabbitmq rabbitmqctl ping --silent

clean-cache:
	@rm -rf apps/*/*/var
	@docker exec librarify-php_ddd-backoffice_backend-php ./apps/backoffice/backend/bin/console cache:warmup
	@docker exec librarify-php_ddd_backend-php ./apps/librarify/backend/bin/console cache:warmup

# 🐳 docker compose nueva version
start-docker: CMD=up -d --build
stop-docker: CMD=stop
destroy-docker: CMD=down

start-docker stop-docker destroy-docker: composer-env-file
	UID=${shell id -u} GID=${shell id -g} docker compose $(CMD)

.PHONY: rebuild-docker
rebuild-docker: composer-env-file
	make deps
	make start-docker
	docker compose build --pull --force-rm --no-cache