Overview

The application implements a simple user management system where users can be created, and notifications are sent when new users are registered. It utilizes a message broker (RabbitMQ) for communication between microservices.

Microservices
users-microservice: Responsible for user management operations, including creating users.
notifications-microservice: Handles sending notifications when new users are registered.

Installation
Clone the repository:

Bash
git clone https://github.com/your-username/microservices-app.git
Use code with caution.
Install dependencies:
Navigate to each service directory (users-service, notifications-service) and run:

Bash
composer install


Configure Environment:

Copy the .env.example file to .env and configure the database connection and RabbitMQ settings.
Run Migrations:


Start RabbitMQ Server:
Ensure RabbitMQ server is running. If not, you can use Docker to start it:

Run Migrations:
php artisan migrate


Usage
Start RabbitMQ server.
Start the queue worker for the "notifications-microservice":
arduino
php artisan queue:work

Dispatch events from the "users-microservice" to trigger notifications:
php artisan fire


Running Services:

Notifications Service:
Bash
cd notifications-service
php artisan queue:work

Users Service:
Bash
cd users-microservice
php artisan serve

This starts the users service development server, making it accessible at http://localhost:8000/users (assuming the default port is used).

Running Tests:
Tests are implemented using PHPUnit. Ensure you have it installed globally (composer global require phpunit/phpunit).
Navigate to each service directory.
Run tests:
Bash
phpunit
Use code with caution.
This executes all unit tests within the service.

Technologies Used
Laravel
RabbitMQ
PHPUnit
Docker


Contributing
Contributions are welcome! Please feel free to submit issues or pull requests.

License
This project is licensed under the MIT License.

