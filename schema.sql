CREATE DATABASE IF NOT EXISTS ProjectManagement;

USE ProjectManagement;

-- Clients Table
CREATE TABLE IF NOT EXISTS Clients (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_info VARCHAR(255) NOT NULL,
    services_required TEXT NOT NULL,
    projected_completion_date DATE NOT NULL,
    amount_charged DECIMAL(10, 2) NOT NULL
);

-- Workers Table
CREATE TABLE IF NOT EXISTS Workers (
    worker_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    work_id VARCHAR(50) NOT NULL UNIQUE,
    specialty VARCHAR(255) NOT NULL
);

-- Services Table
CREATE TABLE IF NOT EXISTS Services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    service_name VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES Clients(client_id)
);

-- Technicians Table (linking services with workers)
CREATE TABLE IF NOT EXISTS Technicians (
    technician_id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id INT NOT NULL,
    service_id INT NOT NULL,
    FOREIGN KEY (worker_id) REFERENCES Workers(worker_id),
    FOREIGN KEY (service_id) REFERENCES Services(service_id)
);

-- Users Table
CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
