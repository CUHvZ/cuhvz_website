-- This is a table to help control displaying the weeklong
CREATE TABLE IF NOT EXISTS weeklongs (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(20) NOT NULL,
  title varchar(20) NOT NULL,
  display_dates varchar(255) NOT NULL,
  active int(5) DEFAULT 0,
  start_date timestamp NULL DEFAULT NULL,
  end_date timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id ( id )
);

insert into weeklongs (name, title, display_dates, start_date, end_date, active) 
	values 
	("weeklongS18", "weeklongS18", "March 19th - March 23rd", "2018-03-19 09:00:00", "2018-03-23 17:00:00", True),
  ("weeklongF17", "Lovecraft", "November 12th - November 16th", "2017-11-12 09:00:00", "2017-11-19 17:00:00", False),
  ("weeklongS17", "Souljourn Preamble", "March 20th - March 24th", "2017-04-20 09:00:00", "2017-03-24 17:00:00", False);