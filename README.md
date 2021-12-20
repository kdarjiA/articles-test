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

## Technical questions

How long did you spend on the coding test? What would you add to your solution if you had more time? If you didn't spend much time on the coding test then use this as an opportunity to explain what you would add.

       I had spent around 5-6 hours on the test. 2 hours for setup the project , create api and created the model and vue js files. other time for the creating the migration and other things.

How would you track down a performance issue in production? Have you ever had to do this?

       Yes, Using the performance monitoring tool like sentry for the track of performance as well as error log for the application.

Please describe yourself using JSON.

       {"name": "Karan darji","current position": "Fullstack developer","hobbies": ["music","programming"],"life motivation": "help to my family, comunity and the team I belong to","values": ["commitment","responsibility","focus","collaboration"],"strong points": ["puntuality","adaptability","resilience"]}



