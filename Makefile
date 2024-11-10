init:
	cp -n .env.example .env
	php composer.phar install
	./vendor/bin/sail build
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail npm install
	./vendor/bin/sail stop

up: up
	./vendor/bin/sail up -d

migrate: up
	./vendor/bin/sail artisan migrate

start: up
	./vendor/bin/sail npm run dev

stop:
	./vendor/bin/sail stop

test: up
	./vendor/bin/sail test
