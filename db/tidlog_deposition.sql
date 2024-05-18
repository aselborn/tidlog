CREATE TABLE `tidlog_deposition` (
  `deposition_id` int NOT NULL AUTO_INCREMENT,
  `hyresgast_id` int NOT NULL,
  `datum_deposition` datetime NOT NULL,
  `belopp` int not null,
  `datum_aterbetalt` datetime ,
  `belopp_ater` int,
  `lagenhet_id` int NOT NULL,
  PRIMARY KEY (`deposition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE tidlog_hyresgaster ADD deposition_id INT NULL after hyresgast_id;
ALTER TABLE tidlog_hyresgaster ADD CONSTRAINT tidlog_hyresgaster_tidlog_deposition_FK FOREIGN KEY (deposition_id) REFERENCES tidlog_deposition (deposition_id);
ALTER TABLE tidlog_deposition ADD CONSTRAINT tidlog_deposition_tidlog_lagenhet_FK FOREIGN KEY (lagenhet_id) REFERENCES tidlog_lagenhet(lagenhet_id);
