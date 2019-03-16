-- The script used to create the users table
CREATE TABLE if not exists weeklongXXX_codes (
id int(11) NOT NULL AUTO_INCREMENT ,
name varchar(30) NOT NULL ,
hex varchar(30) NOT NULL ,
effect varchar(30) NOT NULL ,
side_effect varchar(50),
location_id varchar(255),
single_use boolean DEFAULT True ,
num_uses int(11) DEFAULT 1 ,
expiration varchar(255),
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ) );
