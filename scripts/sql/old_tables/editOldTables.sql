ALTER TABLE weeklongS17 ADD COLUMN `status_type` varchar(255) DEFAULT NULL;
ALTER TABLE weeklongS17 ADD COLUMN `points` int(5) DEFAULT '0';
ALTER TABLE weeklongS17 ADD COLUMN `time_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE weeklongS17 ADD COLUMN `registered` tinyint(1) DEFAULT '0';
ALTER TABLE weeklongS17 ADD COLUMN `starve_timer` int(20) DEFAULT NULL;
ALTER TABLE weeklongS17 ADD COLUMN `waiver` tinyint(1) DEFAULT '0';
ALTER TABLE weeklongS17 ADD COLUMN `bandanna` tinyint(1) DEFAULT '0';

ALTER TABLE weeklongF17 CHANGE memberID user_id int(11);
ALTER TABLE weeklongF17 DROP COLUMN firstName;
ALTER TABLE weeklongF17 DROP COLUMN lastName;
ALTER TABLE weeklongF17 DROP COLUMN active;
ALTER TABLE weeklongF17 DROP COLUMN orient;
ALTER TABLE weeklongF17 ADD COLUMN `status_type` varchar(255) DEFAULT NULL;
ALTER TABLE weeklongF17 ADD COLUMN `points` int(5) DEFAULT '0';
ALTER TABLE weeklongF17 ADD COLUMN `time_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE weeklongF17 ADD COLUMN `registered` tinyint(1) DEFAULT '0';
ALTER TABLE weeklongF17 ADD COLUMN `starve_timer` int(20) DEFAULT NULL;
