-- Créer la base de données
CREATE DATABASE IF NOT EXISTS supermarche_db;
USE supermarche_db;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employe') DEFAULT 'employe'
);
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    quantite INT NOT NULL
);

-- Insérer un utilisateur admin par défaut (mot de passe : admin123)
INSERT INTO users (username, password, role)
VALUES ('admin', SHA2('admin123', 256), 'admin');