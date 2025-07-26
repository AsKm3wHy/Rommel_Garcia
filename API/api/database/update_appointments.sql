-- Add missing columns to appointments table
ALTER TABLE appointments
ADD COLUMN full_name VARCHAR(100) NOT NULL AFTER id,
ADD COLUMN email VARCHAR(100) NOT NULL AFTER full_name,
ADD COLUMN phone VARCHAR(20) NOT NULL AFTER email,
ADD COLUMN appointment_date DATE NOT NULL AFTER phone,
ADD COLUMN appointment_time TIME NOT NULL AFTER appointment_date,
ADD COLUMN status_id INT NOT NULL DEFAULT 1 AFTER appointment_time,
ADD COLUMN notes TEXT AFTER status_id; 