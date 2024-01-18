CREATE TABLE `tidlog_jobs` (
  `JobId` int unsigned NOT NULL AUTO_INCREMENT,
  `job_date` datetime NOT NULL,
  `job_hour` int NOT NULL,
  `job_fastighet` varchar(45) NOT NULL,
  `job_description` varchar(3000) DEFAULT NULL,
  `job_username` varchar(45) NOT NULL,
  `saved_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`JobId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 ;

alter table tidlog_jobs add column job_saved TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER job_date ;