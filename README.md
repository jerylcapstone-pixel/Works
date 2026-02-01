# Homeless Dogs Map - Philippines

A fully developed web application with user authentication and database storage to help locate and assist homeless dogs in the Philippines by plotting their locations on an interactive map.

## Features

- **User Authentication**: Registration and login system with secure password hashing
- **Database Storage**: MySQL database for users and location data
- **Interactive Map**: Centered on the Philippines using Leaflet.js
- **Location Reporting**: Users can report homeless dog locations with coordinates and descriptions
- **Geolocation**: Automatic location detection for easier reporting
- **Professional UI**: Built with Bootstrap 4 for responsive design
- **Comprehensive Validation**: Input validation on both client and server side
- **Error Handling**: Robust error handling and user feedback
- **Session Management**: Secure user sessions

## Setup

1. Ensure PHP 8.3+ and MySQL are installed
2. Start MySQL service: `sudo service mysql start`
3. Create database and tables (run the SQL commands in setup)
4. Start the PHP server: `php -S localhost:8000`
5. Open http://localhost:8000 in your browser
6. Register a new account or login

## Database Setup

```sql
CREATE DATABASE homeless_dogs;

USE homeless_dogs;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lat DECIMAL(10, 8) NOT NULL,
    lng DECIMAL(11, 8) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Project Structure

- `index.php` - Main dashboard (requires login)
- `login.php` - User login page
- `register.php` - User registration page
- `css/style.css` - Custom styles
- `js/script.js` - Frontend JavaScript with validation and geolocation
- `php/db.php` - Database configuration
- `php/get_locations.php` - API to retrieve locations
- `php/add_location.php` - API to add new locations
- `php/logout.php` - Logout handler

## Usage

1. **Register**: Create a new account with username, email, and password
2. **Login**: Access your account
3. **View Map**: See all reported homeless dog locations
4. **Report Location**: Add new locations using coordinates or geolocation
5. **Logout**: Securely end your session

## Security Features

- Password hashing with bcrypt
- Prepared statements to prevent SQL injection
- Session-based authentication
- Input validation and sanitization
- CSRF protection through proper session handling
