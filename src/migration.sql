DROP DATABASE IF EXISTS projetb2; 


CREATE DATABASE IF NOT EXISTS projetb2; 

CREATE USER IF NOT EXISTS 'projetb2' IDENTIFIED BY 'password';

GRANT ALL ON projetb2.* TO 'projetb2';

USE projetb2; 

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    pseudo VARCHAR(25) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    remember_token VARCHAR(255) NULL,
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES roles(id)
);

CREATE TABLE IF NOT EXISTS roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL 
);

CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image BLOB DEFAULT NULL,
    link VARCHAR(255),
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS competences (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL 
);

CREATE TABLE IF NOT EXISTS niveaux (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS users_competences (
    id_user INT,
    id_competence INT,
    id_niveau_comp INT,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_competence) REFERENCES competences(id) ON DELETE CASCADE,
    FOREIGN KEY (id_niveau_comp) REFERENCES niveau_comp(id) ON DELETE CASCADE,
    PRIMARY KEY(id_user, id_competence)
);