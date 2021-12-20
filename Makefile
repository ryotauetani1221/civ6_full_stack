build:
	docker compose build
up:
	docker compose up -d
down:
	docker compose down
restart:
	docker compose restart
laravel:
	docker exec -it laravel sh
next:
	docker exec -it next_app sh
# nginx:
# 	docker exec -it nginx sh
fresh:
	docker compose exec backend php artisan migrate:fresh --seed
yarn_dev:
	docker compose run --rm frontend yarn dev
laravel-install:
	docker compose exec backend composer create-project --prefer-dist laravel/laravel .
create-project:
	@make down
	rm -rf frontend
	rm -rf backend
	mkdir -p frontend
	mkdir -p backend
	@make build
	@make up
	rm -rf backend/vendor
	@make next-restart
	@make laravel-restart
	@make down
	@make up
next-restart:
	make up
	rm -rf frontend
	mkdir -p frontend
	docker compose run --rm frontend yarn global add create-next-app
	docker compose run --rm frontend rm -rf node_modules
	docker compose run --rm frontend rm -rf package.json
	docker compose run --rm frontend rm -rf yarn.lock
	docker compose run --rm frontend yarn create next-app --typescript .
	docker compose run --rm frontend yarn add -D tailwindcss@latest postcss@latest autoprefixer@latest
	docker compose run --rm frontend yarn tailwindcss init -p
	make down
	make up
laravel-restart:
	docker compose exec backend composer create-project --prefer-dist laravel/laravel .
	docker compose exec backend php artisan key:generate --env=sample
	docker compose exec backend php artisan storage:link
	docker compose exec backend chmod -R 777 storage bootstrap/cache
	docker compose exec backend php artisan migrate:fresh --seed
