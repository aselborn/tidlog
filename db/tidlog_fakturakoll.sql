CREATE TABLE tidlog.tidlog_fakturakoll (
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
ALTER TABLE tidlog.tidlog_fakturakoll MODIFY COLUMN fakturakoll_id int(11) auto_increment NOT NULL;