prepare-env:
	echo "DOCKER_UID=$(shell id -u)" > .env.docker
	echo "DOCKER_GID=$(shell id -g)" >> .env.docker
	echo "REDIS_PREFIX=dev" >> .env.docker

prepare-env-prod:
	echo "REDIS_PREFIX=prod" > .env.prod
	echo "CI_ENVIRONMENT=production" >> .env.prod
	echo "APP_ENV=production" >> .env.prod

dev-up:
	test -f public/index.php || ( \
		docker run --rm --dns=8.8.8.8 \
			--user $(shell id -u):$(shell id -g) \
			-v $(PWD):/app -w /app composer:latest \
			composer create-project --ignore-platform-req=ext-intl codeigniter4/appstarter ci && \
		cp -r ci/* . && \
		rm -rf ci \
	)
	chmod -R 775 writable || true
	docker compose up -d --build
	docker compose exec -T app chown -R www-data:www-data writable
	docker compose exec -T app chmod -R 775 writable

dev-down:
	docker compose down --remove-orphans

prod-up:
	test -f public/index.php || ( \
		docker run --rm --dns=8.8.8.8 \
			--user $(shell id -u):$(shell id -g) \
			-v $(PWD):/app -w /app composer:latest \
			composer create-project --ignore-platform-req=ext-intl codeigniter4/appstarter ci && \
		cp -r ci/* . && \
		rm -rf ci \
	)
	chmod -R 775 writable || true
	docker compose -f docker-compose.prod.yml up -d --build
	docker compose -f docker-compose.prod.yml exec -T app chown -R www-data:www-data writable
	docker compose -f docker-compose.prod.yml exec -T app chmod -R 775 writable


prod-down:
	docker compose -f docker-compose.prod.yml down --remove-orphans

reset:
	docker compose down -v --remove-orphans
	sudo rm -rf .env.docker ci vendor writable public app system tests spark phpunit.xml
	sudo rm -rf composer.lock composer.json
	sudo rm -rf README.md .gitignore .htaccess .idea LICENSE env phpunit.xml.dist preload.php builds

logs:
	docker compose logs -f app

monitor:
	docker compose exec app php spark monitor:run

flush-redis:
	docker compose exec redis redis-cli FLUSHALL

flush-redis-prod:
	docker compose -f docker-compose.prod.yml exec redis redis-cli FLUSHALL
