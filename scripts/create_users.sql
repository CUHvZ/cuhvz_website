-- The script used to create the users table
CREATE TABLE if not exists users (
id int(11) NOT NULL AUTO_INCREMENT ,
username varchar(30) NOT NULL ,
firstName varchar(30) NOT NULL ,
lastName varchar(30) NOT NULL ,
email varchar(50) NOT NULL ,
password varchar(255) NOT NULL ,
phone varchar(12),
activated varchar(255) NOT NULL,
admin boolean DEFAULT False ,
subscribed boolean DEFAULT True ,
resetToken varchar(255),
resetComplete varchar(3) DEFAULT "No",
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ),
UNIQUE KEY email ( email ) );