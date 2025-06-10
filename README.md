## Project Setup

Follow the steps below to set up and run the project locally.
Prerequisites

- PHP >= 8.0
- Composer
- Laravel 8 or higher
- MySQL (or MariaDB)

Node.js & NPM (if you're using frontend assets)

*Steps to Set Up*

Clone the Repository

```git clone https://github.com/yourusername/project-name.git
cd project-name
```
Install Composer Dependencies
Run the following command to install the required PHP dependencies:

composer install

Set Up the Environment File
Copy the .env.example file to create your .env file:

cp .env.example .env

Configure Environment Variables
Open the .env file and configure your database connection and other environment settings.

Example for MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_name
DB_USERNAME=root
DB_PASSWORD=

Generate Application Key

php artisan key:generate

Run Migrations & Seeders
To create the database tables and insert initial data, run:

php artisan migrate --seed

Install NPM Dependencies (If using frontend assets)
If you're using frontend assets like Vue.js or React:

npm install

Run Development Server
Run the Laravel development server:

php artisan serve

Access the Application
Open your browser and visit:

    http://localhost:8000

Database Structure
1. Users (Freelancers)

    Table: users

    Fields:

        id (primary key)

        name

        email (unique)

        password

        created_at

        updated_at

2. Clients

    Table: clients

    Fields:

        id (primary key)

        user_id (foreign key referencing users.id)

        name

        email

        contact_person

        created_at

        updated_at

3. Projects

    Table: projects

    Fields:

        id (primary key)

        client_id (foreign key referencing clients.id)

        title

        description

        status (enum: active, completed)

        deadline (date)

        created_at

        updated_at

4. Time Logs

    Table: time_logs

    Fields:

        id (primary key)

        project_id (foreign key referencing projects.id)

        start_time (datetime)

        end_time (datetime)

        description

        hours (calculated)

        created_at

        updated_at

### . Required Packages
```
composer install
```
