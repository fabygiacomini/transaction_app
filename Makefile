CONTAINER := transaction-app

# primeira inicialização do sistema (roda seeders)
prepare-environment: docker-up install prepare-database

# inicia o sistema
start: docker-up install migrate

docker-up:
	docker-compose up -d

install:
	docker exec $(CONTAINER) composer install

# prepara a primeira inicialização do banco de dados
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

test:
	docker exec $(CONTAINER) php artisan test
