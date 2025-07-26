-- Create the database
CREATE DATABASE IF NOT EXISTS rommelgarciaappointments;
USE rommelgarciaappointments;

-- Create appointment_statuses table
CREATE TABLE IF NOT EXISTS appointment_statuses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(50) NOT NULL
);

-- Insert default statuses
INSERT INTO appointment_statuses (status) VALUES
    ('pending'),
    ('confirmed'),
    ('completed'),
    ('cancelled')
ON DUPLICATE KEY UPDATE status=VALUES(status);

-- Create appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status_id INT NOT NULL DEFAULT 1,
    notes TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (status_id) REFERENCES appointment_statuses(id)
); 