CREATE TABLE `tidlog_lagenhet` (
  `lagenhet_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fastighet_id` int NOT NULL,
  `lagenhet_nr` int NOT NULL,
  `yta` int NOT NULL,
  PRIMARY KEY (`lagenhet_id`)
) ENGINE=InnoDB  ;
