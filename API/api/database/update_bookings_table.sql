-- Add status_id column to bookings table
ALTER TABLE bookings 
ADD COLUMN status_id INT NOT NULL DEFAULT 1,
ADD FOREIGN KEY (status_id) REFERENCES booking_statuses(id);

-- Update existing bookings to use the default status (Pending)
UPDATE bookings SET status_id = 1 WHERE status_id IS NULL; 