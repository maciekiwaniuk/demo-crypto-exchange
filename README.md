# Demo crypto exchange - under development...

> ### Project of the single page application demo cryptocurrencies exchange

- Backend is made in Symfony 6.
- Frontend is made in Vue 3 using Composition API with TypeScript.

# Manual configuration

To successfully install you need to have installed [composer](https://getcomposer.org/download/), [npm](https://docs.npmjs.com/cli/v7/commands/npm-install), [PHP](https://www.php.net/downloads.php) with version >= 8.1, [Symfonu CLI](https://symfony.com/download) and database environment (for example [XAMPP](https://www.apachefriends.org/pl/index.html) - localhost).

Open folder where you want to have project files, open console and then clone the repository

    git clone https://github.com/maciekiwaniuk/demo-crypto-exchange
	
Change folder in console to created folder with project files

	cd demo-crypto-exchange

Install all the dependencies using composer

    composer install
	
Run npm install command

	npm install
	
Run npm run dev command to compile js files

	npm run dev

Fill .env file to your needs and delete .env.local file

    DATABASE_URL="mysql://--USER--:--PASSWORD--@localhost/--DATABASE--?charset=utf8mb4"

Generate the SSL keys

    php bin/console lexik:jwt:generate-keypair

Run the database migrations (**Set the database connection in .env before migrating**)

    php bin/console doctrine:migrations:migrate

Start the local development server

    symfony serve

You can now access the server at http://127.0.0.1:8000

# Docker configuration

Firstly build containers, for the first time it might take some time

    docker-compose up --build -d

Change environment to docker in .env

    APP_ENV=docker

After that you need to set permission in MySQL container

    docker exec -it mysql bash
    mysql -u root --password=""
    CREATE USER 'root'@'%' IDENTIFIED BY '';
    GRANT ALL ON *.* TO 'root'@'%';

Finally, you need to enter a few commands in php container

    docker exec -it php bash
    composer install -n
    php bin/console lexik:jwt:generate-keypair --overwrite
    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction
    npm install
    npm run dev

Access server at http://127.0.0.1:8000

# Testing

## Backend

Configure database for testing

    php bin/console --env=test doctrine:database:create
    php bin/console --env=test doctrine:schema:create

Run backend tests

    php bin/phpunit

## Frontend

Run frontend unit tests

    npm run test

Run E2E tests

    npx cypress run

