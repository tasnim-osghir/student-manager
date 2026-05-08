-- =============================================
-- Student Manager - Database Creation Script
-- =============================================

CREATE DATABASE IF NOT EXISTS student_manager;
USE student_manager;

-- Table etudiants
CREATE TABLE IF NOT EXISTS etudiants (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    filiere    VARCHAR(100),
    note       FLOAT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Données de test
INSERT INTO etudiants (nom, prenom, email, filiere, note) VALUES
('Alami',   'Youssef', 'youssef@email.com', 'Informatique',  15.5),
('Benali',  'Sara',    'sara@email.com',    'Mathematiques', 17.0),
('Chraibi', 'Amine',   'amine@email.com',   'Physique',      13.0);