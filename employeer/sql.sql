CREATE DATABASE watch_brand_db;

USE watch_brand_db;

CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    founded_year INT,
    website VARCHAR(255)
);