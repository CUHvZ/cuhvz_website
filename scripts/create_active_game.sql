-- This is a table to help control displaying the weeklong
CREATE TABLE IF NOT EXISTS current_weeklong (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(20) NOT NULL,
  display_dates varchar(255) NOT NULL,
  active boolean DEFAULT False,
  start_date timestamp NULL DEFAULT NULL,
  end_date timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id ( id )
);

insert into current_weeklong (name, display_dates, start_date, end_date, active) 
	values 
	("weeklongS18", "March 19th - March 23rd", "2018-03-19 09:00:00", "2018-03-23 17:00:00", True);