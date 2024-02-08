CREATE TABLE `tidlog_lagenhet` (
  `lagenhet_id` int NOT NULL AUTO_INCREMENT,
  `fastighet_id` int NOT NULL,
  `lagenhet_nr` int NOT NULL,
  `yta` int NOT NULL,
  PRIMARY KEY (`lagenhet_id`),
  UNIQUE KEY `lagenhet_id_UNIQUE` (`lagenhet_id`),
  KEY `fk_fastighet_id_idx` (`fastighet_id`),
  CONSTRAINT `fk_fastighet_id` FOREIGN KEY (`fastighet_id`) REFERENCES `tidlog_fastighet` (`fastighet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
