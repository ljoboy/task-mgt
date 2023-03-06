.PHONY: install seed test build serve

all: install seed test build serve

install:
	composer install
	php artisan key:generate
	php artisan storage:link

build:
	npm i
	npm run build

seed:
	php artisan migrate:fresh --seed

test:
	php artisan test

serve:
	php artisan serve
