# Rental Management System

## Overview
The Rental Management System is a web-based application designed to streamline the process of managing rental properties, tenants, and payments efficiently. It allows landlords to track rental units, manage tenant information, process payments, and generate reports.

## Features
- **User Authentication**: Secure login/logout for landlords and tenants.
- **Property Management**: Add, edit, and delete rental properties.
- **Tenant Management**: Store tenant details, lease agreements, and payment history.
- **Payment Tracking**: Record rental payments and generate receipts.
- **Automated Reminders**: Notify tenants of upcoming rent due dates.
- **Reports & Analytics**: View rental income reports and tenant statistics.
- **Admin Dashboard**: Centralized control panel for managing the system.

## Technologies Used
- **Backend**: PHP (Core PHP or Laravel)
- **Frontend**: HTML, CSS (Bootstrap/Tailwind), JavaScript
- **Database**: MySQL
- **Server**: XAMPP/LAMP/WAMP

## Installation
### Prerequisites
Ensure you have the following installed:
- XAMPP/WAMP/LAMP
- PHP (v7.4+ recommended)
- MySQL Database

### Steps
1. Clone the repository:
   ```bash
   https://github.com/AmirZaid11/rental-management-system.git
   ```
2. Navigate to the project directory:
   ```bash
   cd rental-management-system
   ```
3. Import the database:
   - Open **phpMyAdmin**.
   - Create a new database (e.g., `house_rental_db`).
   - Import the `house_rental_db.sql` file from the `database` folder.
4. Configure the database connection:
   - Open `config.php`.
   - Update database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'rental_db');
     ```
5. Start the server:
   ```bash
   php -S localhost:8000
   ```
6. Access the application in the browser:
   ```
   http://localhost:8000
   ```

## Usage
- **Landlord Login**: Manage properties, tenants, and payments.
- **Tenant Login**: View rental details, payment history, and submit payments.
- **Admin Dashboard**: Control system-wide settings and user management.

## Screenshots


## Contribution
Feel free to fork the repository and submit pull requests.

## License
This project is licensed under the MIT License.

## Contact
For inquiries, reach out via:
- **Email**: eddysimba9@gmail.com
- **Phone**: +254715264486
