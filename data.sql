-- Create the database
CREATE DATABASE IF NOT EXISTS study_planner;
USE study_planner;

-- Create the tasks table
CREATE TABLE IF NOT EXISTS study_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course VARCHAR(100) NOT NULL,
    task TEXT NOT NULL,
    study_date DATE NOT NULL,
    duration TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;