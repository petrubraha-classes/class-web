
CREATE DATABASE IF NOT EXISTS test;
USE test;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
    id              INT          AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(255) NOT NULL,
    email           VARCHAR(255) UNIQUE NOT NULL,
    hashed_password VARCHAR(255) NOT NULL,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO user (username, email, hashed_password)
    VALUES ('petru', 
    'petrubraha@gmail.com', '$2y$10$jkHG8jbjm8FOY0DZjtEI6eXupAafqz51Frhc234H6sQtLq.iC0X4O');
