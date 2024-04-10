CREATE TABLE tidlog_faktura (
	faktura_id INT auto_increment NOT NULL,
	hyresgast_id INT NOT NULL,
	lagenhet_id INT NULL,
	park_id int ,
	faktura blob,
	fakturanummer varchar(40) not NULL,
	FakturaDatum DATETIME not NULL,
	ocr varchar(100) NOT NULL,
	duedate DATETIME not NULL,
	specifikation varchar(100) NULL,
	faktura_year int not null,
	faktura_month int not null,
	CONSTRAINT tidlog_faktura_pk PRIMARY KEY (faktura_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;

ALTER TABLE tidlog_faktura ADD belopp_hyra INT null after faktura_id;
ALTER TABLE tidlog_faktura ADD belopp_parkering int null after belopp_hyra;