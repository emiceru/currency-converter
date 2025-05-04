
# Makefile para automatizar tareas del proyecto Laravel Currency Converter

install:
	composer install
	cp .env.example .env || copy .env.example .env
	php artisan key:generate
	php artisan migrate

serve:
	php artisan serve

test:
	php artisan test

tinker:
	php artisan tinker

lint:
	php artisan pint

update:
	composer update

migrate:
	php artisan migrate

seed:
	php artisan db:seed

fresh:
	php artisan migrate:fresh --seed


dev-user:
	php artisan db:seed --class=DevUserSeeder
