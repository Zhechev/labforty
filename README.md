# Appointment Booking System

A web application for adding, viewing, editing, and deleting appointments, as well as notifying users of their scheduled appointments.

## Features

- Adding new appointments with data validation
- List of all saved appointments with filters and pagination
- Detailed view of specific appointments
- Editing and deleting appointments
- Display of other upcoming appointments for the same client
- API endpoints for all functionalities
- Client notification via Email or SMS (simulated)

## Technical Details

- Laravel 10
- MySQL database
- Repository Pattern for data access
- Strategy Pattern for notifications
- Factory Pattern for creating notifications
- SOLID principles
- Input data validation
- Responsive design with Bootstrap 5

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js and NPM (for compiling assets)

## Installation

### Option 1: Standard Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/appointment-system.git
cd appointment-system
```

2. Install dependencies:

```bash
composer install
```

3. Copy the `.env.example` file and rename it to `.env`:

```bash
cp .env.example .env
```

4. Generate an application key:

```bash
php artisan key:generate
```

5. Configure the database connection in the `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appointment_system
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations:

```bash
php artisan migrate
```

7. (Optional) Load test data:

```bash
php artisan db:seed
```

### Option 2: Docker Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/appointment-system.git
cd appointment-system
```

2. Start Docker containers:

```bash
docker-compose up -d
```

3. Install dependencies:

```bash
docker-compose exec app composer install
```

4. Copy the `.env.example` file and rename it to `.env`:

```bash
cp .env.example .env
```

5. Generate an application key:

```bash
docker-compose exec app php artisan key:generate
```

6. Run migrations:

```bash
docker-compose exec app php artisan migrate
```

7. (Optional) Load test data:

```bash
docker-compose exec app php artisan db:seed
```

## Running the Application

### Standard Method

1. Start the local server:

```bash
php artisan serve
```

2. Open the application in your browser:

```
http://localhost:8000
```

### Docker Method

1. After starting Docker containers with `docker-compose up -d`, access the application at:

```
http://localhost:8081
```

2. Access phpMyAdmin at:

```
http://localhost:8080
```

## API Documentation

The application provides the following API endpoints:

### List of Appointments

```
GET /api/appointments
```

Filter parameters:
- `egn` - Client's ID number
- `date_from` - Start date
- `date_to` - End date

### Appointment Details

```
GET /api/appointments/{id}
```

### Create Appointment

```
POST /api/appointments
```

Parameters:
- `appointment_datetime` - Date and time (format: Y-m-d H:i)
- `client_name` - Client's name
- `egn` - Client's ID number (10 digits)
- `description` - Description (optional)
- `notification_method` - Notification method (email or sms)
- `email` - Email address (required if notification_method is email)
- `phone` - Phone number (required if notification_method is sms)

### Update Appointment

```
PUT /api/appointments/{id}
```

Parameters: same as for creation

### Delete Appointment

```
DELETE /api/appointments/{id}
```

## Project Structure

The project follows the standard Laravel structure with additional directories:

- `app/Repositories` - Repositories for data access
- `app/Services` - Business logic and services
- `app/Services/Notification` - Classes for client notifications
- `app/Rules` - Custom validation rules

## Author

Mitko Zhechev
