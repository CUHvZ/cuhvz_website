-- The script used to create the users table
CREATE TABLE if not exists user_stats (
id int(11) NOT NULL ,
join_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
weeklongs_played varchar(30) NULL ,
lockins_played varchar(30) NULL ,
activated boolean NOT NULL DEFAULT false,
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ) );
