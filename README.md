## Project Setup

Follow the steps below to set up and run the project locally.
Prerequisites

- PHP >= 8.3
- Composer
- Laravel 12
- MySQL (or MariaDB)

Node.js & NPM (if you're using frontend assets)

*Steps to Set Up*

Clone the Repository

```git clone https://github.com/ashab20/time-tracker-freelancer
cd time-tracker-freelancer
```
Install Composer Dependencies
Run the following command to install the required PHP dependencies:
```
composer install
```
Set Up the Environment File
Copy the .env.example file to create your .env file:

```
cp .env.example .env
```
Configure Environment Variables
Open the .env file and configure your database connection and other environment settings.

Example for MySQL:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=time_tracker
DB_USERNAME=root
DB_PASSWORD=
```
Generate Application Key

```
php artisan key:generate
```

Run Migrations & Seeders
To create the database tables and insert initial data, run:

```
php artisan migrate --seed
```

Run Development Server
Run the Laravel development server:
```
php artisan serve
```
Access the Application
Open your postman and request:
``
http://localhost:8000/api
``
## Database Structure

### 1. Users (Freelancers)

| Field         | Type         | Description                                  |
|---------------|--------------|----------------------------------------------|
| `id`          | Primary Key  | Unique identifier for the user               |
| `name`        | String       | The name of the freelancer                   |
| `email`       | String (Unique) | The email address of the freelancer          |
| `password`    | String       | The password for the freelancer              |
| `created_at`  | Timestamp    | When the user was created                    |
| `updated_at`  | Timestamp    | When the user was last updated               |

---

### 2. Clients

| Field         | Type         | Description                                  |
|---------------|--------------|----------------------------------------------|
| `id`          | Primary Key  | Unique identifier for the client             |
| `user_id`     | Foreign Key  | References the `id` field in the `users` table |
| `name`        | String       | The name of the client                       |
| `email`       | String       | The email address of the client              |
| `phone` | String    | The contact person at the client             |
| `address` | String    | The address of client             |
| ` city` | String    | The city name of the client             |
| ` state` | String    | The state name of  the client             |
| ` zip` | String    | The zip code of the client             |
| `created_at`  | Timestamp    | When the client was created                  |
| `updated_at`  | Timestamp    | When the client was last updated             |

---

### 3. Projects

| Field         | Type         | Description                                  |
|---------------|--------------|----------------------------------------------|
| `id`          | Primary Key  | Unique identifier for the project            |
| `client_id`   | Foreign Key  | References the `id` field in the `clients` table |
| `title`       | String       | The title of the project                     |
| `description` | Text         | The description of the project               |
| `status`      | Enum         | Project status (active, completed)           |
| `deadline`    | Date         | The project deadline date                    |
| `created_at`  | Timestamp    | When the project was created                 |
| `updated_at`  | Timestamp    | When the project was last updated            |

---

### 4. Time Logs

| Field         | Type         | Description                                  |
|---------------|--------------|----------------------------------------------|
| `id`          | Primary Key  | Unique identifier for the time log entry     |
| `project_id`  | Foreign Key  | References the `id` field in the `projects` table |
| `start_time`  | DateTime     | The start time of the logged work            |
| `end_time`    | DateTime     | The end time of the logged work              |
| `description` | Text         | Description of the work logged               |
| `hour`       | Float        | Calculated hours from `start_time` and `end_time` |
| `created_at`  | Timestamp    | When the time log was created                |
| `updated_at`  | Timestamp    | When the time log was last updated           |

## API Endpoints
Authentication

- POST /api/login – Login a freelancer.
- POST /api/logout – Logout a freelancer.
- POST /api/register – Register a new freelancer.

Clients
- POST /api/clients – Create a new client.
- GET /api/clients – List all clients for the logged-in freelancer.
- GET /api/clients/{id} – View a specific client.
- PUT /api/clients/{id} – Update a client.
- DELETE /api/clients/{id} – Delete a client.

Projects

- POST /api/projects – Create a new project for a client.
- GET /api/projects – List all projects for the logged-in freelancer.
- GET /api/projects/{id} – View a specific project.
- PUT /api/projects/{id} – Update a project.
- DELETE /api/projects/{id} – Delete a project.

Time Logs
- POST /api/time_logs – Create a new time log entry.
- GET /api/time_logs – List all time logs for the logged-in freelancer.
- GET /api/time_logs/{id} – View a specific time log.
- PUT /api/time_logs/{id} – Update a time log entry.
- DELETE /api/time_logs/{id} – Delete a time log entry.

TIME START & END
- POST /api/time_logs/{projectId}/start – Start Time For Specifice project with project Id.
- POST /api/time_logs/{projectId}/end – END Time For Specifice project with project Id

Reports

- GET /api/report?client_id=1&from=2024-01-01&to=2024-01-07 – Get total logged hours (by client, project, or date range).
