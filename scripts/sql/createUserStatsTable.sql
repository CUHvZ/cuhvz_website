-- The script used to create the users table
CREATE TABLE if not exists UserStats (
id int(11) NOT NULL AUTO_INCREMENT ,
join_date timestamp NULL DEFAULT NULL,
weeklongs_played varchar(30) NOT NULL ,
lockins_played varchar(30) NOT NULL ,
activated varchar(255) NOT NULL,
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ),
UNIQUE KEY email ( email ) );
