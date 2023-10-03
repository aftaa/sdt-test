CREATE DATABASE sdt;
CREATE USER sdt@'%' IDENTIFIED BY 'sdt';
GRANT ALL PRIVILEGES ON sdt.* TO sdt@'%';

USE sdt;

CREATE TABLE clients
(
    id   INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE merchandise
(
    id   INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price INT UNSIGNED NOT NULL
);

CREATE TABLE orders
(
    id          INT UNSIGNED             NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_id     INT UNSIGNED             NOT NULL,
    customer_id INT UNSIGNED             NOT NULL,
    comment     TEXT                     NOT NULL,
    status      ENUM ('new', 'complete') NOT NULL DEFAULT 'new',
    order_date  DATE                     NOT NULL,

    CONSTRAINT fk_merchandise FOREIGN KEY (item_id) REFERENCES merchandise (id) ON DELETE CASCADE,
    CONSTRAINT fk_clients FOREIGN KEY (customer_id) REFERENCES clients (id) ON DELETE CASCADE
);
