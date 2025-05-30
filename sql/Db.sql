-- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS peams;
USE peams;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('admin', 'employee') NOT NULL DEFAULT 'employee'
);

-- ATTENDANCE TABLE
CREATE TABLE IF NOT EXISTS attendance (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    Status ENUM('Present', 'Absent', 'Late') DEFAULT 'Present',
    FOREIGN KEY (User_ID) REFERENCES users(ID) ON DELETE CASCADE
);

-- LEAVE REQUESTS TABLE
CREATE TABLE IF NOT EXISTS leave_requests (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Reason TEXT NOT NULL,
    From_Date DATE NOT NULL,
    To_Date DATE NOT NULL,
    Status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    Cancelled BOOLEAN DEFAULT 0,
    FOREIGN KEY (User_ID) REFERENCES users(ID) ON DELETE CASCADE
);

-- INSERT DEFAULT ADMIN USER
INSERT INTO users (Name, Email, Password, Role)
VALUES ('Admin User', 'admin@peams.com', MD5('admin123'), 'admin');
