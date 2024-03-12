CREATE TABLE tidlog.tidlog_hyreskoll (
	hyreskoll_id INT NOT NULL,
	lagenhet_id INT NOT NULL,
	hyresgast_id varchar(100) NOT NULL,
	belopp_inbetalt INT NOT NULL,
	belopp INT NULL,
	datum_inbetald DATETIME NULL,
	sen BIT NULL,
	CONSTRAINT tidlog_hyreskoll_pk PRIMARY KEY (hyreskoll_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;