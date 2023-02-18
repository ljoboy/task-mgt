.PHONY: install npm

install:
	composer install
	php artisan key:generate
	php artisan storage:link
	php artisan migrate:fresh --seed

npm:
	npm i
	npm run dev

seed:
	php artisan migrate:fresh --seed

test:
	php artisan test
