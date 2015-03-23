DROP DATABASE IF EXISTS test;
CREATE DATABASE test;

USE test;

CREATE TABLE users (
	id			INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name		NVARCHAR(20),
	password	NVARCHAR(32)
);

CREATE TABLE companies (
	id 			INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name 		NVARCHAR(20),
	address		NVARCHAR(50),
	description	NVARCHAR(500)
);

CREATE TABLE feedback_percentage (
	id			INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	company_id	INTEGER NOT NULL,
	vote		INTEGER NOT NULL
);

CREATE TABLE company_feedbacks (
	id			INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	company_id	INTEGER NOT NULL,
	feedback	VARCHAR(500) NOT NULL
);

INSERT INTO users(name, password) VALUES('lol', '9cdfb439c7876e703e307864c9167a15');


INSERT INTO companies(name, address, description) VALUES('Azienda1', 'via delle rose 12, roma', 'Azienda di antiquariato');
INSERT INTO companies(name, address, description) VALUES('Azienda2', 'via dei gigli 113, milano', 'Azienda di quadri');
INSERT INTO companies(name, address, description) VALUES('Azienda3', 'via delle margherite 6, napoli', 'Azienda di statue');

