CREATE TABLE tidlog.tidlog_meddelande (
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
