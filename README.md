# Demo crypto exchange - development stopped due to lack of time

> ### Project of the single page application demo cryptocurrencies exchange

- Backend is made in Symfony 6.
- Frontend is made in Vue 3 using Composition API with TypeScript.

# Commands

To successfully install you need to have installed docker.

Open folder where you want to have project files, open console and then clone the repository

    git clone https://github.com/maciekiwaniuk/demo-crypto-exchange
	
Change folder in console to created folder with project files

	cd demo-crypto-exchange

Run docker

    docker-compose up -d

Run environment file

    docker-compose exec php cp .env.dist .env

Run composer

    docker-compose exec php composer install
	
Run npm install command

	docker-compose exec php npm install
	
Run npm run dev command to compile js files

	docker-compose exec php npm run dev

Generate the SSL keys

    docker-compose exec php bin/console lexik:jwt:generate-keypair

Run the database migrations (**Set the database connection in .env before migrating**)

    docker-compose exec php bin/console doctrine:migrations:migrate

Load fixtures

    docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

You can now access the server at http://localhost:80


# Testing

## Backend

Run tests

    docker-compose exec php bin/phpunit

## Frontend

Run frontend unit tests

    docker-compose exec php npm run test

Run E2E tests

    npx cypress run
