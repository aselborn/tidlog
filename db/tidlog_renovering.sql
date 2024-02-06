CREATE TABLE `tidlog_renovering` (
  `renovering_id` int unsigned NOT NULL AUTO_INCREMENT,
  `lagenhet_id` int NOT NULL,
  `StartTid` DATETIME NOT NULL,
  `SlutTid` DATETIME ,
  `total_kostnad` INT ,
  `kommentar` VARCHAR(1000) NULL,
  PRIMARY KEY (`renovering_id`)
) ENGINE=InnoDB ;
