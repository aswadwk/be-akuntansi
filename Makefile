setup:
	@make down
	@make up
	@make optimize

build:
	docker build -t awswadwk/accontant-app ./docker/app

up:
	docker compose up -d

down:
	docker compose down

migrate:
	docker exec accountant php artisan migrate

optimize:
	docker exec accountant php artisan optimize
