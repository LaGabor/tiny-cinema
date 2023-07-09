# Tiny Cinema

This project is a web application that allows users to book seats in a fictional cinema hall. It is built using PHP with Laravel and Java Script with Vue.js.

## Functionality

The Tiny Cinema application provides the following functionality:

1. Users can view the available seats in the cinema hall.
2. Users can book one or two seats simultaneously.
3. Only one successful booking can be made for a particular seat at a time.
4. If a payment for a booking fails, the seat is released after 2 minutes.
5. Users can see the status of each seat, which can be "available," "booked," or "sold."
6. After a successful booking, users are prompted to provide their email address for receiving an email confirmation. The seat status is then changed to "sold."

## Installation and Setup

To install and set up the Tiny Cinema project, follow these steps:

1. Make sure you have the required dependencies, such as PHP, Laravel, Composer, and npm, installed on your system before proceeding with the installation.<br>
2. Clone the repository to your local machine.<br>
3. Run *`composer install`* inside the backend directory to install the PHP dependencies.<br>
4. Create a new database with your prefered SQL language.<br>
5. Inside the backend directory rename the `.env.example` file to `.env` and update the necessary configuration values, such as the database and *mail connection details.<br>
6. Generate an application key by running *`php artisan key:generate`*.<br>
7. Run *`php artisan migrate --seed`* to migrate the database schema and create the two seats.<br>
8. Inside the frontend directory run *`npm install`* to install the JavaScript dependencies.<br>
9. Inside the backend directory start the development server by running *`php artisan serve --port=8000`*.<br>
10. Inside the frontend directory start the development server by running *`npm run serve -- --port 8080`*.<br>
11. Access the application in your web browser at *`http://localhost:8080`*.<br>

*How to make password(app password) for the MAIL_PASSWORD variable in the .env file :https://www.youtube.com/watch?v=T0Op3Qzz6Ms&ab_channel=VishnuVardhanSana<br>
*If using Gmail, .env variable values: MAIL_PORT=587, MAIL_HOST=smtp.gmail.com, MAIL_ENCRYPTION=tls<br>

<div align="center">
 <strong>Thank you for your time!</strong>
<div><br>

![hcX](https://github.com/LaGabor/bardi-laravel-demo/assets/88590636/a4179e8a-c7be-4566-844e-92c22592b5c5)

