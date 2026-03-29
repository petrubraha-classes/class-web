CREATE DATABASE IF NOT EXISTS facebook;

USE facebook;

DROP TABLE post;

CREATE TABLE post (
    username    VARCHAR(50) PRIMARY KEY,
    description TEXT,
    imageUrl    VARCHAR(2048)
);

INSERT INTO post VALUES ("petru", "a photo with my donk.", "res/donk.jpg");
INSERT INTO post VALUES ("cosmin", "picture with my friend.", "res/fr.jpg");
