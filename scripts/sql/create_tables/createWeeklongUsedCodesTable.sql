-- The script used to create the users table
CREATE TABLE if not exists weeklongXXX_used_codes (
id int(11) NOT NULL AUTO_INCREMENT ,
user_id int(11) NOT NULL ,
code_id int(11) NOT NULL ,
time_used timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ) );
