CREATE TABLE tidlog_inlogg (
	inloggId INT primary key auto_increment NOT NULL,
	username varchar(100) NOT NULL,
	ipadress varchar(100) NULL,
	logdate DATETIME NOT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;
