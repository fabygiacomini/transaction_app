CONTAINER := transaction-app

prepare-environment: docker-up install prepare-database

docker-up:
	docker-compose up -d

install:
	docker exec $(CONTAINER) composer install

prepare-database: migrate seed-user seed-wallet

migrate:
	docker exec $(CONTAINER) php artisan migrate

seed-user:
	docker exec $(CONTAINER) php artisan db:seed UserSeeder

seed-wallet:
	docker exec $(CONTAINER) php artisan db:seed WalletSeeder

reset-database:
	docker exec $(CONTAINER) php artisan migrate:reset

docker-down:
	docker-compose down
