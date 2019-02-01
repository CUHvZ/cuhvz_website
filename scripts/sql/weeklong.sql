-- This is a template for creating a new weeklong game
CREATE TABLE IF NOT EXISTS weeklongS17 (
  user_id int(11) NOT NULL,
  username varchar(30) NOT NULL ,
  status varchar(255) NOT NULL DEFAULT 'human',
  user_hex varchar(5) NOT NULL,
  kill_count varchar(5) NOT NULL DEFAULT 0,
  starve_date timestamp NULL DEFAULT NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY user_id ( user_id )
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;