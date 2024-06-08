CREATE TABLE `tidlog_inbetalningar` (
  `inbetalning_id` int NOT NULL AUTO_INCREMENT,
  `faktura_id` int NOT NULL,
  `inbetald` datetime NOT NULL,
  `belopp` int NOT NULL,
  `diff_belopp` int NOT NULL,
  PRIMARY KEY (`inbetalning_id`),
  KEY `tidlog_inbetalningar_tidlog_faktura_FK` (`faktura_id`),
  CONSTRAINT `tidlog_inbetalningar_tidlog_faktura_FK` FOREIGN KEY (`faktura_id`) REFERENCES `tidlog_faktura` (`faktura_id`)
) ENGINE=InnoDB