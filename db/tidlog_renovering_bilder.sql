CREATE TABLE `tidlog_renovering_bilder` (
  `idtidlog_renovering_bilder_id` int NOT NULL AUTO_INCREMENT,
  `tidlog_renovering_id` int NOT NULL,
  `bilddata` blob,
  `fildata` blob,
  `kommentar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idtidlog_renovering_bilder_id`),
  UNIQUE KEY `idtidlog_renovering_bilder_id_UNIQUE` (`idtidlog_renovering_bilder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Innehåller bilder och dokument för renoverade lägenheter';
