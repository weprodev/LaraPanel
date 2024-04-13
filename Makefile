#########################################################
#  _                     _____                 _
# | |                   |  __ \               | |
# | |     __ _ _ __ __ _| |__) |_ _ _ __   ___| |
# | |    / _` | '__/ _` |  ___/ _` | '_ \ / _ \ |
# | |___| (_| | | | (_| | |  | (_| | | | |  __/ |
# |______\__,_|_|  \__,_|_|   \__,_|_| |_|\___|_|
#########################################################

.DEFAULT_GOAL := help

# Help Message
.PHONY: help
help:
	@printf "Usage\n";

	@awk '{ \
			if ($$0 ~ /^.PHONY: [a-zA-Z\-\_0-9]+$$/) { \
				helpCommand = substr($$0, index($$0, ":") + 2); \
				if (helpMessage) { \
					printf "\033[36m%-20s\033[0m %s\n", \
						helpCommand, helpMessage; \
					helpMessage = ""; \
				} \
			} else if ($$0 ~ /^[a-zA-Z\-\_0-9.]+:/) { \
				helpCommand = substr($$0, 0, index($$0, ":")); \
				if (helpMessage) { \
					printf "\033[36m%-20s\033[0m %s\n", \
						helpCommand, helpMessage; \
					helpMessage = ""; \
				} \
			} else if ($$0 ~ /^##/) { \
				if (helpMessage) { \
					helpMessage = helpMessage"\n                     "substr($$0, 3); \
				} else { \
					helpMessage = substr($$0, 3); \
				} \
			} else { \
				if (helpMessage) { \
					print "\n                     "helpMessage"\n" \
				} \
				helpMessage = ""; \
			} \
		}' \
		$(MAKEFILE_LIST)


## INSTALLING AND PREPARING LOCAL ENVIRONEMTN
.PHONY: install
install:
	composer install
	php ./../../artisan init:git
	exit 0

## Clear Cache
.PHONY: clear
clear:
	php artisan route:clear
	php artisan view:clear
	php artisan config:clear
	php artisan cache:clear
	php artisan config:cache
	exit 0

## RUNNING TESTCASES
.PHONY: test
test:
	@echo "\n====>  Running phpstan ....\n\n" && \
    ./vendor/bin/phpstan analyse

	@echo "\n\n====>  Running Pint: code style testing ....\n\n" &&\
    ./vendor/bin/pint --test
	exit 0

## FIXING CODE STYLES
.PHONY: pint
pint:
	./vendor/bin/pint
	exit 0
