-- The script used to create the users table
CREATE TABLE IF NOT EXISTS weeklong_details (
  weeklong_id int(11) NOT NULL,
  waiver_link_path TEXT,
  details TEXT,
  monday TEXT,
  tuesday TEXT,
  wednesday TEXT,
  thursday TEXT,
  friday TEXT,
  PRIMARY KEY (weeklong_id),
  UNIQUE KEY user_id ( weeklong_id )
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
