-- This is a template for creating a new weeklong game
CREATE TABLE IF NOT EXISTS weeklong (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  status varchar(255) NOT NULL DEFAULT 'human',
  UserHex varchar(5) NOT NULL,
  KillCount varchar(5) NOT NULL,
  StarveDate timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY user_id ( user_id )
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;