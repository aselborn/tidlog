#Upgrade script april 2024

# skapa tidlog_item 

-- tidlog.tidlog_item definition
CREATE TABLE `tidlog_item` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `artikel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kommentar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



ALTER TABLE tidlog_artikel ADD item_id INT NOT NULL after hyresgast_id;
ALTER TABLE tidlog_artikel ADD CONSTRAINT tidlog_artikel_tidlog_item_FK FOREIGN KEY (item_id) REFERENCES tidlog_item(item_id);
ALTER TABLE tidlog_artikel MODIFY COLUMN med_hyra TINYINT NOT NULL;
ALTER TABLE tidlog_artikel ADD momsbelopp DOUBLE NULL after totalbelopp;
ALTER TABLE tidlog_artikel DROP COLUMN artikel;
ALTER TABLE tidlog_artikel CHANGE belopp nettobelopp int NOT NULL;


# tidlog.faktakoll
drop table tidlog_fakturakoll  
CREATE TABLE tidlog_fakturakoll (
	fakturakoll_id INT NOT NULL AUTO_INCREMENT,
	faktura_id INT NOT NULL,
	dt_inbetald DATETIME NOT NULL,
	dt_kollad DATETIME NOT NULL,
	kollad_av varchar(100) NOT NULL,
	diff INT NOT NULL,
	hyresgast_id INT NOT NULL,
	CONSTRAINT tidlog_fakturakoll_pk PRIMARY KEY (fakturakoll_id),
	CONSTRAINT tidlog_fakturakoll_tidlog_faktura_FK FOREIGN KEY (faktura_id) REFERENCES tidlog.tidlog_faktura(faktura_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;
ALTER TABLE tidlog_fakturakoll MODIFY COLUMN fakturakoll_id int(11) auto_increment NOT NULL;

CREATE TABLE tidlog_meddelande (
	meddelande_id INT auto_increment NOT NULL,
	meddelande varchar(200) NOT NULL,
	hyresgast_id INT NOT NULL,
	giltlig_fran DATETIME NOT NULL,
	giltlig_till DATETIME NOT NULL,
	CONSTRAINT tidlog_meddelande_pk PRIMARY KEY (meddelande_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

# tidlog.retrohyra
drop table tidlog_retro_hyra 
CREATE TABLE `tidlog_retro_hyra` (
  `retro_id` int NOT NULL AUTO_INCREMENT,
  `lagenhet_id` int NOT NULL,
  `lagenhetNo` varchar(100) DEFAULT NULL,
  `hyra_retro` int NOT NULL,
  `giltlig_datum` DATETIME NOT NULL,
  `sparad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`retro_id`),
  KEY `tidlog_retro_hyra_tidlog_lagenhet_FK` (`lagenhet_id`),
  CONSTRAINT `tidlog_retro_hyra_tidlog_lagenhet_FK` FOREIGN KEY (`lagenhet_id`) REFERENCES `tidlog_lagenhet` (`lagenhet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



insert into tidlog_retro_hyra (lagenhet_id, lagenhetNo, hyra_retro, giltlig_datum, sparad )
select tl.lagenhet_id , tl.lagenhet_nr , tl.hyra, '2023-11-26', current_timestamp()  from tidlog_lagenhet tl 
inner join tidlog_hyresgaster th on tl.hyresgast_id  = th.hyresgast_id 



ALTER TABLE tidlog_parkering ADD fastighet_id int NULL;
update tidlog_parkering set fastighet_id = 1 where parknr IN (15811,15812,15813,15814,15815,15816,15817,15818,15819,15820,15821,15822)
update tidlog_parkering set fastighet_id = 2 where parknr IN (1,2,3,4,5,6)

--  Auto-generated SQL script #202404102153
UPDATE tidlog_fastighet
	SET fastighet_address='Sörgårdsgatan'
	WHERE fastighet_id=2;
