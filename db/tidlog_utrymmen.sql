-- tidlog.tidlog_utrymmen definition

CREATE TABLE `tidlog_utrymmen` (
  `vind_id` int NOT NULL AUTO_INCREMENT,
  `nummer` varchar(100) NOT NULL,
  `kommentar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`vind_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8