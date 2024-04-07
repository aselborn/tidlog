-- tidlog.tidlog_artikel definition

CREATE TABLE `tidlog_artikel` (
  `artikel_id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `med_hyra` bit(1) NOT NULL,
  `hyresgast_id` int NOT NULL,
  `artikel` varchar(100) NOT NULL,
  `belopp` int NOT NULL,
  `totalbelopp` int NOT NULL,
  `moms` int DEFAULT NULL,
  `kommentar` varchar(100) DEFAULT NULL,
  `giltlig_from` datetime NOT NULL,
  `giltlig_tom` datetime DEFAULT NULL,
  `skapad` datetime DEFAULT NULL,
  PRIMARY KEY (`artikel_id`),
  KEY `tidlog_artikel_tidlog_hyresgaster_FK` (`hyresgast_id`),
  CONSTRAINT `tidlog_artikel_tidlog_hyresgaster_FK` FOREIGN KEY (`hyresgast_id`) REFERENCES `tidlog_hyresgaster` (`hyresgast_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Extra avgifter';

ALTER TABLE tidlog_artikel ADD item_id INT NOT NULL after hyresgast_id;
ALTER TABLE tidlog_artikel ADD CONSTRAINT tidlog_artikel_tidlog_item_FK FOREIGN KEY (item_id) REFERENCES tidlog.tidlog_item(item_id);
ALTER TABLE tidlog_artikel MODIFY COLUMN med_hyra TINYINT NOT NULL;
ALTER TABLE tidlog_artikel ADD momsbelopp DOUBLE NULL after totalbelopp;
ALTER TABLE tidlog_artikel DROP COLUMN artikel;
ALTER TABLE tidlog_artikel CHANGE belopp nettobelopp int NOT NULL;