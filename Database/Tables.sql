-- CREATE DATABASE Eventbrite;

use Eventbrite;

CREATE TABLE roles(
      role_id INT PRIMARY KEY AUTO_INCREMENT ,
      role_name VARCHAR(30)
);

CREATE Table users(
      user_id INT AUTO_INCREMENT PRIMARY KEY,
      fname VARCHAR (255),
      lname VARCHAR (255),
      email VARCHAR(255) UNIQUE NOT NULL,
      password VARCHAR(255) NOT NULL ,
      status ENUM('active','suspend') DEFAULT 'active',
      role_id int ,
      photo VARCHAR(255),
      birthdate DATE,
      bio VARCHAR(255),
      joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

CREATE TABLE Categories(
       categorie_id INT PRIMARY KEY AUTO_INCREMENT ,
       categorie_name VARCHAR(255) UNIQUE NOT NULL
);
CREATE TABLE Tags(
     tag_id INT PRIMARY KEY AUTO_INCREMENT  ,
     tag_name VARCHAR(255) UNIQUE NOT NULL
);


CREATE TABLE  events(
        event_id INT AUTO_INCREMENT PRIMARY KEY ,
        event_creator INT,
        event_title VARCHAR(255) NOT NULL,
        event_description  TEXT  NOT NULL,
        event_city VARCHAR (255),
        event_link VARCHAR (255),
        event_price float (10,2) DEFAULT  0.00,
        event_address VARCHAR(255) NOT NULL,
        event_capacity INT DEFAULT 10,
        event_category INT NOT NULL,
        event_type ENUM('vip', 'free', 'paid', 'earlybird'),
        event_status ENUM('accepted', 'rejected'),
        event_date DATE,
        created_at DATE,
        promo_code INT DEFAULT -1,
        available_seats INT DEFAULT (event_capacity),
        thumbnail VARCHAR(255),
        video VARCHAR(255),
        FOREIGN KEY (event_creator) REFERENCES users(user_id),
        FOREIGN KEY (event_category) REFERENCES categories(categorie_id),
        FOREIGN KEY (promo_code) REFERENCES promo_codes(code_id)
);

CREATE Table event_tags(
       event_id INT,
       tag_id INT,
       PRIMARY KEY (event_id ,tag_id ),
       FOREIGN KEY (tag_id) REFERENCES Tags(tag_id) on DELETE CASCADE,
       FOREIGN KEY (event_id) REFERENCES events(event_id) on DELETE CASCADE
);

CREATE TABLE promo_codes(
         code_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
         code VARCHAR(25),
         discount INT(2),
         expiring_date DATE
);


CREATE TABLE Tickets(
       ticket_id int PRIMARY KEY AUTO_INCREMENT NOT NULL ,
       event_id INT,
       buyer_id INT,
       promo_code_id INT,
       QR_code VARCHAR(255),
       Foreign Key (event_id) REFERENCES events(event_id) on DELETE CASCADE,
       Foreign Key (buyer_id) REFERENCES users(user_id) on DELETE CASCADE,
       Foreign Key (promo_code_id) REFERENCES promo_codes(code_id) on DELETE CASCADE
);

CREATE Table Notification(
     notification_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
     notification_message VARCHAR(255),
     notification_time TIME,
     is_read BOOLEAN default false,
     receiver_id INT  ,
     FOREIGN KEY (receiver_id) REFERENCES users(user_id) on DELETE CASCADE
);

CREATE Table Comments
(
    comment_id      INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id         INT,
    event_id        INT,
    comment_content varchar(255),
    commented_at    datetime DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE support (
    message_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NULL ,
    message_content varchar(255),
    fullname varchar(50),
    sender_email varchar(255),
    send_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) on DELETE CASCADE
);




