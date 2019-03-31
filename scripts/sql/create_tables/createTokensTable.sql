CREATE TABLE if not exists tokens (
id int(11) NOT NULL AUTO_INCREMENT ,
user_id int(11) NOT NULL ,
token varchar(255) NOT NULL ,
token_type varchar(30) NOT NULL ,
expiration timestamp NOT NULL ,
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ) );
