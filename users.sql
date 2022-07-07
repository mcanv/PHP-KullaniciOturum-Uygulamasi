CREATE DATABASE php_auth;
USE php_auth;

CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(256) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at DATETIME NOT NULL
);

INSERT INTO users (name, email, password, is_admin) VALUES("Admin", "admin@example.com", "$2y$10$qi0mb7dVspPCBFMJFePizeCtjB1Wlqv3FKcNBx/HRl5SWwPTidAeW", 1);
/* 
password: admin123
*/
