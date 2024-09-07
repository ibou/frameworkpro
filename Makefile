.PHONY: help

env ?= dev 

## Colors
COLOR_RESET			= \033[0m
COLOR_ERROR			= \033[31m
COLOR_INFO			= \033[32m
COLOR_COMMENT		= \033[33m
COLOR_TITLE_BLOCK	= \033[0;44m\033[37m

#---SYMFONY--#
DOCKER_PHP = docker exec -it php83 bash
#------------#
 
DOCKER_COMPOSE = docker-compose -p php-framework
#---PHPUNIT-#
PHPUNIT = vendor/bin/phpunit
#------------#

## launch docker containers, no rebuild
start:
	@$(DOCKER_COMPOSE) up -d --build --force-recreate --remove-orphans

## stop docker containers
stop:
	@$(DOCKER_COMPOSE) stop

## down docker containers
down:
	@$(DOCKER_COMPOSE) down

logs:
	@$(DOCKER_COMPOSE) logs -f

## stop docker containers
restart: stop start

## shell app
shell-app:
	@$(DOCKER_PHP)

tests:
	docker exec -it php83 sh -c "cd framework && vendor/bin/phpunit tests --colors"

domimi:
	docker exec php83 php bin/console database:migrations:migrate