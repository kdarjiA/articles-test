## Installation
Clone the repository

    git clone git@github.com:kdarjiA/articles-test.git

Switch to the repo folder

    cd articles-test

Install all the dependencies using composer

    composer install

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:refresh --seed

***Note*** : Above command will create one test user with email "admin@admin.com" and password "password".
For creating new user you can visit this URL {host_name}/register

Run below command to install node packages

    npm install
    npm run dev     

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
