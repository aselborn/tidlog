CREATE TABLE `tidlog_hyresgaster` (
  `hyresgast_id` int unsigned NOT NULL AUTO_INCREMENT,
  `lagenhet_id` int NOT NULL,
  `fnamn` varchar(45) NOT NULL,
  `enamn` varchar(45) NOT NULL,
  `epost` varchar(200) DEFAULT NULL,
  `telefon` varchar(100) NOT NULL,
  PRIMARY KEY (`hyresgast_id`),
  KEY `fk_lagenhet_idx` (`lagenhet_id`),
  CONSTRAINT `fk_lagenhet` FOREIGN KEY (`lagenhet_id`) REFERENCES `tidlog_lagenhet` (`lagenhet_id`)
) ENGINE=InnoDB ;


ALTER TABLE `tidlog`.`tidlog_hyresgaster` 
ADD COLUMN `andrahand` TINYINT NULL DEFAULT 0 AFTER `epost`;

ALTER TABLE tidlog_hyresgaster ADD adress varchar(100) null after lagenhet_id;
ALTER TABLE tidlog_hyresgaster ADD LghNo INT NULL COMMENT 'Kolumnen används för att ha historik för vem som bodde var.';

# update LghNo
update tidlog_hyresgaster th
inner join tidlog_lagenhet tl on th.hyresgast_id =tl.hyresgast_id 
set th.LghNo  = tl.lagenhet_nr 
