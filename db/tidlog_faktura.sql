CREATE TABLE tidlog.tidlog_fakutra (
	faktura_id INT auto_increment NOT NULL,
	hyresgast_id INT NOT NULL,
	lagenhet_id INT NULL,
	park_id int ,
	fakturanummer INT NULL,
	FakturaDatum DATETIME NULL,
	ocr varchar(100) NOT NULL,
	duedate DATETIME NULL,
	specifikation varchar(100) NULL,
	CONSTRAINT tidlog_fakutra_pk PRIMARY KEY (faktura_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;
