# Admin Markdown

## Getting started

* Create a `.env` file from the `.env.example` file
* Install dependencies
  * `composer install`
  * `npm install && npm run dev`
* Set up the database
  * `php artisan migrate`
* Create a user
  * `php artisan app:user:create {username} {password}`
* Start the application
  * `php artisan serve`

> You should be able to access the application using the address `http://localhost:8080`
