
DROP TABLES IF EXISTS Laureates, LaureateBirth, OrgLaureates, LaureatePrizes;

CREATE TABLE Laureates(
    id INT NOT NULL,
    givenName VARCHAR(30),
    familyName VARCHAR(30),
    gender VARCHAR(10),
    PRIMARY KEY(id)
);


CREATE TABLE LaureateBirth(
    id INT NOT NULL,
    birthDate DATE,
    city VARCHAR(30),
    country VARCHAR(35),
    PRIMARY KEY(id)
);


CREATE TABLE OrgLaureates(
    id INT NOT NULL,
    orgName VARCHAR(60),
    foundedDate DATE,
    city VARCHAR(30),
    country VARCHAR(30),
    PRIMARY KEY(id)
);


CREATE TABLE LaureatePrizes(
    id INT NOT NULL,
    awardYear INT NOT NULL,
    category VARCHAR(30),
    sortOrder INT,
    portion VARCHAR(6),
    prizeStatus VARCHAR(15),
    dateAwarded DATE,
    motivation VARCHAR(345),
    prizeAmount VARCHAR(15),
    affilName VARCHAR(115),
    affilCity VARCHAR(30),
    affilCountry VARCHAR(30)
);

LOAD DATA LOCAL INFILE 'laureates.del' INTO TABLE Laureates
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE 'laureate_birth.del' INTO TABLE LaureateBirth
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE 'org_laureates.del' INTO TABLE OrgLaureates
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE 'laureate_prize.del' INTO TABLE LaureatePrizes
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';