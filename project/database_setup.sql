-- ===================================================
-- MySQL Database Setup for Data Structures Project
-- ===================================================

-- Step 1: Create Database
CREATE DATABASE IF NOT EXISTS project;

-- Step 2: Use the Database
USE project;

-- Step 3: Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    cnic VARCHAR(20) NOT NULL UNIQUE,
    dob DATE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Step 4: Create Algorithms History Table (for tracking user activities)
CREATE TABLE IF NOT EXISTS algorithm_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    algorithm_name VARCHAR(100) NOT NULL,
    execution_time FLOAT,
    input_size INT,
    steps_count INT,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Step 5: Create User Performance Table
CREATE TABLE IF NOT EXISTS user_performance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    algorithm_name VARCHAR(100) NOT NULL,
    times_practiced INT DEFAULT 0,
    best_time FLOAT,
    last_practiced TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_algo (user_id, algorithm_name)
);

-- Step 6: Create Index for Better Performance
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_user_cnic ON users(cnic);
CREATE INDEX idx_algorithm_history_user ON algorithm_history(user_id);
CREATE INDEX idx_user_performance_user ON user_performance(user_id);

-- ===================================================
-- Optional: Insert Test Data (Comment out if not needed)
-- ===================================================

-- INSERT INTO users (fullname, email, phone, cnic, dob, password) VALUES
-- ('Test User', 'test@example.com', '0300-1234567', '12345-1234567-1', '1990-01-01', '$2y$10$V9pVnFjm7K3D4c5X2yZ1Ku6Q8oL3M9nP1qR5sT7uV8w9xYz0aB1cD');

-- ===================================================
-- Instructions to Setup Database:
-- ===================================================
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click "New" button to create new database
-- 3. Go to SQL tab
-- 4. Copy all content from this file and paste in SQL tab
-- 5. Click "Go" button to execute
-- OR
-- 6. Import this file directly: 
--    - Click Import tab in phpMyAdmin
--    - Choose this file (database_setup.sql)
--    - Click "Go"

-- ===================================================
-- Database Details:
-- ===================================================
-- Database Name: project
-- Username: root
-- Password: (empty/blank)
-- Host: localhost
-- Port: 3306
