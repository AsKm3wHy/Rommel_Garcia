-- Create appointments table
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(20) NOT NULL UNIQUE,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `appointment_type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photobooth_type` varchar(50) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `notes` text,
  `admin_notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `appointment_date` (`appointment_date`),
  KEY `reference_number` (`reference_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create appointment statuses table
CREATE TABLE IF NOT EXISTS `appointment_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `color` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default statuses
INSERT INTO `appointment_statuses` (`name`, `description`, `color`) VALUES
('Pending', 'Appointment is pending confirmation', 'warning'),
('Confirmed', 'Appointment has been confirmed', 'info'),
('Completed', 'Appointment has been completed', 'success'),
('Cancelled', 'Appointment has been cancelled', 'danger'),
('No Show', 'Client did not show up', 'secondary');

-- Add foreign key constraint
ALTER TABLE `appointments`
ADD CONSTRAINT `fk_appointment_status` FOREIGN KEY (`status_id`) REFERENCES `appointment_statuses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE; 