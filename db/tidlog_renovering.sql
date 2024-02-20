CREATE TABLE `tidlog_renovering` (
  `renovering_id` int NOT NULL AUTO_INCREMENT,
  `lagenhet_id` int NOT NULL,
  `datum_start` datetime NOT NULL,
  `datum_stop` datetime DEFAULT NULL,
  `material` mediumtext,
  `total_kostnad` int DEFAULT NULL,
  PRIMARY KEY (`renovering_id`),
  UNIQUE KEY `renovering_id_UNIQUE` (`renovering_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
