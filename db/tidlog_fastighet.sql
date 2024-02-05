CREATE TABLE `tidlog_fastighet` (
  `fastighet_id` int NOT NULL AUTO_INCREMENT,
  `fastighet_namn` varchar(50) NOT NULL,
  `fastighet_address` varchar(100) NOT NULL,
  PRIMARY KEY (`fastighet_id`),
  UNIQUE KEY `fastighet_id_UNIQUE` (`fastighet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Fastighetstabell';
