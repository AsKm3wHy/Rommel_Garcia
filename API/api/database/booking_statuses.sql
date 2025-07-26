CREATE TABLE IF NOT EXISTS `booking_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `color` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default statuses
INSERT INTO `booking_statuses` (`name`, `description`, `color`, `created_at`, `updated_at`) VALUES
('Pending', 'Booking is pending confirmation', 'warning', NOW(), NOW()),
('Confirmed', 'Booking has been confirmed', 'info', NOW(), NOW()),
('Completed', 'Booking has been completed', 'success', NOW(), NOW()),
('Cancelled', 'Booking has been cancelled', 'danger', NOW(), NOW()),
('No Show', 'Client did not show up', 'secondary', NOW(), NOW());

-- Update bookings table to reference status
ALTER TABLE `bookings` 
ADD COLUMN `status_id` int(11) NOT NULL DEFAULT 1,
ADD FOREIGN KEY (`status_id`) REFERENCES `booking_statuses`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE; 