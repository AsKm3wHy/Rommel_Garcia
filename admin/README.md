# Admin Dashboard Backend Implementation

This document describes the backend implementation for the admin dashboard using PDO PHP.

## Overview

The admin dashboard has been enhanced with a complete backend system that connects to the `rommelgarciaappointments` database to display real-time appointment data.

## File Structure

```
admin/
├── config/
│   ├── database.php          # Database connection configuration
│   └── error_handler.php     # Error handling and utility functions
├── models/
│   └── Appointment.php       # Appointment data model and queries
├── js/
│   └── dashboard.js          # Enhanced JavaScript functionality
├── logs/                     # Error and action logs (auto-created)
├── index.php                 # Main dashboard page with backend integration
└── README.md                 # This documentation file
```

## Features Implemented

### 1. Database Integration
- **PDO Connection**: Secure database connection using PDO with error handling
- **Real-time Data**: Dashboard statistics are pulled directly from the database
- **Search Functionality**: Both client-side and server-side search capabilities

### 2. Dashboard Statistics
- **Total Appointments**: Count of all appointments in the system
- **New Appointments**: Count of appointments created today
- **Today's Sessions**: Count of appointments scheduled for today
- **Upcoming Sessions**: Count of appointments in the next 7 days

### 3. Appointment Tables
- **Today's Appointments**: Shows all appointments scheduled for today
- **Upcoming Appointments**: Shows appointments for the next 7 days
- **Search Functionality**: Filter appointments by client name
- **Empty States**: Proper handling when no appointments exist

### 4. Error Handling
- **Database Connection Errors**: Graceful handling of connection failures
- **Query Errors**: Proper error logging and user-friendly messages
- **Input Validation**: Sanitization of all user inputs and outputs
- **Logging System**: Comprehensive logging of errors and admin actions

### 5. Security Features
- **SQL Injection Prevention**: Using prepared statements
- **XSS Prevention**: Output sanitization using `htmlspecialchars`
- **Input Validation**: Proper trimming and validation of search terms

## Database Schema

The system uses the existing `appointments` table with the following structure:

```sql
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
);
```

## Key Functions

### Appointment Model (`models/Appointment.php`)

- `getTotalAppointments()`: Returns total count of all appointments
- `getNewAppointments()`: Returns count of appointments created today
- `getTodaySessions()`: Returns count of today's appointments
- `getUpcomingSessions()`: Returns count of upcoming appointments
- `getTodayAppointments()`: Returns today's appointment details
- `getUpcomingAppointments()`: Returns upcoming appointment details
- `searchAppointments()`: Searches today's appointments by client name
- `searchUpcomingAppointments()`: Searches upcoming appointments by client name

### Error Handler (`config/error_handler.php`)

- `customErrorHandler()`: Handles PHP errors
- `customExceptionHandler()`: Handles exceptions
- `handleDatabaseError()`: Handles database-specific errors
- `validateDatabaseConnection()`: Validates database connectivity
- `sanitizeOutput()`: Sanitizes output for XSS prevention
- `formatDateTime()`: Formats date/time for display
- `formatDate()`: Formats date for display

## Usage

### Basic Usage
1. Ensure the database `rommelgarciaappointments` exists and is accessible
2. The dashboard will automatically load appointment data
3. Use the search boxes to filter appointments by client name

### Search Functionality
- **Real-time Search**: Type in the search boxes for instant filtering
- **Server-side Search**: Use the search forms for more comprehensive searches
- **Keyboard Shortcuts**: 
  - `Ctrl/Cmd + F`: Focus on first search box
  - `Escape`: Clear active search

### Error Handling
- Database connection errors are displayed as user-friendly messages
- All errors are logged to `logs/error.log`
- Database-specific errors are logged to `logs/db_error.log`
- Admin actions are logged to `logs/admin_actions.log`

## Configuration

### Database Configuration (`config/database.php`)
```php
private $host = "localhost";
private $db_name = "rommelgarciaappointments";
private $username = "root";
private $password = "";
```

### Error Logging
- Error logs: `logs/error.log`
- Database error logs: `logs/db_error.log`
- Admin action logs: `logs/admin_actions.log`
- Critical error logs: `logs/critical.log`

## Security Considerations

1. **SQL Injection**: All queries use prepared statements
2. **XSS Prevention**: All output is sanitized using `htmlspecialchars`
3. **Input Validation**: Search terms are trimmed and validated
4. **Error Information**: Detailed errors are logged but not displayed to users
5. **Database Credentials**: Should be moved to environment variables in production

## Performance Optimizations

1. **Prepared Statements**: Reused for better performance
2. **Indexed Queries**: Uses primary keys and date indexes
3. **Efficient Date Queries**: Uses MySQL date functions for filtering
4. **Client-side Filtering**: Real-time search without server requests

## Future Enhancements

1. **AJAX Integration**: Real-time data updates without page refresh
2. **Pagination**: For large datasets
3. **Export Functionality**: Export appointment data to CSV/PDF
4. **Email Notifications**: For new appointments
5. **Calendar Integration**: Direct calendar view integration
6. **User Authentication**: Admin login system
7. **Role-based Access**: Different access levels for different admin roles

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **No Data Displayed**
   - Check if appointments table has data
   - Verify table structure matches expected schema
   - Check error logs for specific issues

3. **Search Not Working**
   - Ensure JavaScript is enabled
   - Check browser console for errors
   - Verify search form submission

### Log Files
- Check `logs/error.log` for general errors
- Check `logs/db_error.log` for database-specific issues
- Check `logs/admin_actions.log` for user activity

## Dependencies

- PHP 7.4+ with PDO extension
- MySQL 5.7+ or MariaDB 10.2+
- Modern web browser with JavaScript enabled

## Installation

1. Ensure all files are in the correct directory structure
2. Create the `logs` directory (auto-created by error handler)
3. Configure database connection in `config/database.php`
4. Import the database schema if not already present
5. Access the dashboard through `admin/index.php`

## Support

For issues or questions:
1. Check the log files for detailed error information
2. Verify database connectivity and permissions
3. Ensure all required PHP extensions are enabled
4. Check browser console for JavaScript errors 