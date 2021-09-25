

--Movie table
--primary key is id
CREATE TABLE Movie (
    id INT NOT NULL,
    title VARCHAR(100),
    year INT,
    rating VARCHAR(10),
    company VARCHAR(50),
    PRIMARY KEY (id)
);


--Actor table 
--primary key is id
CREATE TABLE Actor (
    id INT NOT NULL,
    last VARCHAR(20),
    first VARCHAR(20),
    sex VARCHAR(6),
    dob DATE,
    dod DATE,
    PRIMARY KEY (id)
);


--Director table
--primary key is id
CREATE TABLE Director (
    id INT NOT NULL,
    last VARCHAR(20),
    first VARCHAR(20),
    dob DATE,
    dod DATE,
    PRIMARY KEY (id)
);


--MovieGenre table
--no primary key
CREATE TABLE MovieGenre (
    mid INT,
    genre VARCHAR(20)
);


--MovieDirector table
--no primary key
CREATE TABLE MovieDirector (
    mid INT,
    did INT
);


--MovieActor table
--no primary key
CREATE TABLE MovieActor (
    mid INT,
    aid INT,
    role VARCHAR(50)
);


--Review table
--no primary key
CREATE TABLE Review (
    name VARCHAR(20),
    time DATETIME,
    mid INT,
    rating INT,
    comment TEXT
);


