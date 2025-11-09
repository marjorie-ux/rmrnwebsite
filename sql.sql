CREATE DATABASE IF NOT EXISTS recipe_db;
USE recipe_db;

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    ingredients TEXT NOT NULL,  -- Store as comma-separated list (e.g., "Flour, Salt, Water") for simplicity
    instructions TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);