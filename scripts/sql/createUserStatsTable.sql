-- The script used to create the users table
CREATE TABLE if not exists user_stats (
id int(11) NOT NULL ,
join_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
weeklongs_played varchar(30) NULL DEFAULT 0,
lockins_played varchar(30) NULL DEFAULT 0 ,
activated boolean NOT NULL DEFAULT false,
PRIMARY KEY ( id ) ,
UNIQUE KEY id ( id ) );
