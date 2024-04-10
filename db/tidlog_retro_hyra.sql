-- tidlog.tidlog_retro_hyra definition

CREATE TABLE `tidlog_retro_hyra` (
  `retro_id` int NOT NULL AUTO_INCREMENT,
  `lagenhet_id` int NOT NULL,
  `lagenhetNo` varchar(100) DEFAULT NULL,
  `hyra_retro` int NOT NULL,
  `sparad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`retro_id`),
  KEY `tidlog_retro_hyra_tidlog_lagenhet_FK` (`lagenhet_id`),
  CONSTRAINT `tidlog_retro_hyra_tidlog_lagenhet_FK` FOREIGN KEY (`lagenhet_id`) REFERENCES `tidlog_lagenhet` (`lagenhet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE tidlog_retro_hyra ADD giltlig_datum DATETIME NOT NULL after hyra_retro; 