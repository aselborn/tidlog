CREATE TABLE `tidlog_kontrakt` (
  `kontrakt_id` int  NOT NULL AUTO_INCREMENT,
  `lagenhet_id` int NOT NULL,
  `hyresgast_id` int NOT NULL,
  `datum` datetime NOT NULL,
  `kontrakt` longblob,
  PRIMARY KEY (`kontrakt_id`),
  KEY `fk_lagenhet_id_idx` (`lagenhet_id`),
  CONSTRAINT `fk_lagenhet_id` FOREIGN KEY (`lagenhet_id`) REFERENCES `tidlog_lagenhet` (`lagenhet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `tidlog`.`tidlog_kontrakt` 
ADD INDEX `fk_lagenhet_id_idx` (`lagenhet_id` ASC) VISIBLE;
;
ALTER TABLE `tidlog`.`tidlog_kontrakt` 
ADD CONSTRAINT `fk_lagenhet_id`
  FOREIGN KEY (`lagenhet_id`)
  REFERENCES `tidlog`.`tidlog_lagenhet` (`lagenhet_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE tidlog.tidlog_kontrakt ADD datum_uppsagd DATETIME NULL;
