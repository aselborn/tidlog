CREATE TABLE tidlog_faktura_extra (
	faktura_id INT NOT NULL,
	extrabelopp INT NOT NULL,
	extradatum DATETIME NOT NULL,
	CONSTRAINT tidlog_faktura_extra_tidlog_faktura_fk FOREIGN KEY (faktura_id) REFERENCES tidlog_faktura(faktura_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4;
