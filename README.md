# Hospital Management System

A web-based Hospital Management System built with Laravel. The system helps hospitals manage patients, doctors, appointments, medical records, prescriptions, laboratory services, billing, and other hospital information through a centralized platform.

## Features

* Patient Management
* Doctor Management
* Department Management
* Appointment Management
* Medical Records
* Prescription Management
* Billing & Payments
* User Authentication
* Role-based Access Control
* Dashboard & Reports

## Tech Stack

* Laravel
* PHP
* PostgreSQL
* Blade
* Bootstrap/Tailwind CSS
* JavaScript

## Requirements

* PHP 8.x
* Composer
* PostgreSQL
* Node.js & npm (if using Vite)

## Installation

1. Clone the repository

```bash
git clone <repository-url>
```

2. Navigate to the project

```bash
cd hospital-management-system
```

3. Install dependencies

```bash
composer install
npm install
```

4. Copy the environment file

```bash
cp .env.example .env
```

5. Generate the application key

```bash
php artisan key:generate
```

6. Configure the database in `.env`

7. Run migrations

```bash
php artisan migrate
```

8. Start the development server

```bash
php artisan serve
```

9. Start the Vite development server

```bash
npm run dev
```

## Project Structure

* `app/` - Application logic
* `routes/` - Application routes
* `resources/views/` - Blade templates
* `database/` - Migrations and seeders
* `public/` - Public assets

## Author

**Synit Maharjan**

## License

This project is for educational purposes.
