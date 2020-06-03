.DEFAULT_GOAL := check

PHPCS_CACHE_DIR := /tmp/cache
PHPCS_ARGS := --standard=ruleset.xml --extensions=php,phpt --encoding=utf-8 --cache=$(PHPCS_CACHE_DIR)/phpcs --tab-width=4 -sp Core Tests
TESTER_ARGS := -o console -s -p php -c Tests/php.ini -l /var/log/nette_tester.log

.PHONY: check
check: lint phpmnd phpstan psalm phpcs tests

.PHONY: ci
ci: check tester-coverage

.PHONY: help
help:               ## help
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

.PHONY: lint
lint:               ## lint
	vendor/bin/parallel-lint -e php,phpt Core Tests

.PHONY: phpmnd
phpmnd:             ## phpmnd
	vendor/bin/phpmnd Core
	vendor/bin/phpmnd Tests

.PHONY: phpstan
phpstan:            ## phpstan
	vendor/bin/phpstan analyse -l max -c phpstan.neon Core
	#@make phpstan-test --no-print-directory

.PHONY: phpstan-test
phpstan-test:
	PHPSTAN=1 vendor/bin/phpstan analyse -l max -c phpstan.test.neon Tests

.PHONY: psalm
psalm:              ## psalm
	vendor/bin/psalm --show-info=false

.PHONY: phpcs
phpcs:              ## phpcs
	@mkdir -p $(PHPCS_CACHE_DIR)
	vendor/bin/phpcs $(PHPCS_ARGS)

.PHONY: phpcbf
phpcbf:             ## phpcbf
	@mkdir -p $(PHPCS_CACHE_DIR)
	vendor/bin/phpcbf $(PHPCS_ARGS)

.PHONY: tests
tests:              ## tests
	vendor/bin/tester $(TESTER_ARGS) Tests/

.PHONY: tester-coverage
tester-coverage:
	vendor/bin/tester $(TESTER_ARGS) -d extension=xdebug.so Tests/ --coverage tester-coverage.xml --coverage-src Core/

.PHONY: echo-failed-tests
echo-failed-tests:
	@for i in $(find Tests -name \*.actual); do echo "--- $i"; cat $i; echo; echo; done
	@for i in $(find Tests -name \*.expected); do echo "--- $i"; cat $i; echo; echo; done

.PHONY: composer-install
composer-install:
	composer install --no-interaction --prefer-dist --no-scripts --no-progress --no-suggest --classmap-authoritative
