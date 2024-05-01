.PHONY: install up

install: up
	@echo "Running database migration script inside Docker container..."
	@docker exec -it php-skeleton /bin/bash -c "composer install && php bin/console doctrine:database:create && php bin/console doctrine:migrations:migrate"

up:
	@echo "Running docker-compose up -d..."
	@docker-compose up -d

.PHONY: migrations

migrations:
	@echo "Running database migration script inside Docker container..."
	@docker exec -it php-skeleton /bin/bash -c "php bin/console doctrine:migrations:migrate"

.PHONY: start

start:
	@echo "Running docker-compose up -d..."
	@docker-compose up -d
