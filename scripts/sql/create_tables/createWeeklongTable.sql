-- The script used to create the users table
CREATE TABLE IF NOT EXISTS weeklongXXX (
  user_id int(11) NOT NULL,
  status varchar(255) NOT NULL DEFAULT 'human',
  username varchar(255) NOT NULL,
  status_type varchar(255),
  user_hex varchar(5) NOT NULL,
  points int(5) DEFAULT '0',
  kill_count varchar(5) NOT NULL DEFAULT 0,
  starve_date timestamp NULL DEFAULT NULL,
  time_joined timestamp DEFAULT CURRENT_TIMESTAMP,
  registered boolean DEFAULT false,
  starve_timer int(20) DEFAULT NULL,
  waiver boolean DEFAULT false,
  bandanna boolean DEFAULT false,
  PRIMARY KEY (user_id),
  UNIQUE KEY user_id ( user_id )
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
