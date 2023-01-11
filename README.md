# Demo crypto exchange - under development...

> ### Project of the single page application demo cryptocurrencies exchange

- Backend is made in Symfony 6.
- Frontend is made in Vue 3 using Composition API.

# Installation

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

Fill .env file to your needs

    DATABASE_URL="mysql://--USER--:--PASSWORD--@localhost/--DATABASE--?charset=utf8mb4"

Generate the SSL keys

    php bin/console lexik:jwt:generate-keypair

Run the database migrations (**Set the database connection in .env before migrating**)

    php bin/console doctrine:migrations:migrate

Start the local development server

    symfony serve

You can now access the server at http://127.0.0.1:8000

Or simply use docker - SOON...
