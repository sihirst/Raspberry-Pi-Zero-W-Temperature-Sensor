CREATE TABLE climate (
    id INT PRIMARY KEY AUTO_INCREMENT,
    `key` VARCHAR(255) NOT NULL,
    temperature FLOAT NOT NULL,
    humidity FLOAT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL
);
