-- This is a template for creating a new weeklong game
CREATE TABLE IF NOT EXISTS weeklongF18_activity (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_1 int(11) NOT NULL,
  action varchar(30) NOT NULL ,
  user_2 int(11) NULL DEFAULT NULL,
  time timestamp NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id ( id )
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

INSERT INTO `weeklongF18_activity` (`id`, `user_1`, `action`, `user_2`, `time`) VALUES
(1, 106, 'starved', null, '2018-09-26 11:14');
