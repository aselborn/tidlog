-- tidlog.tidlog_special_faktura definition

CREATE TABLE `tidlog_special_faktura` (
  `faktura_spec_id` int(11) NOT NULL,
  `belopp_netto` int(11) NOT NULL,
  `belopp_moms` int(11) DEFAULT NULL,
  `specifikation` varchar(400) NOT NULL,
  `datum_skapad` datetime NOT NULL,
  `datum_sista_betalning` datetime DEFAULT NULL,
  `fastighet_id` int(11) NOT NULL,
  PRIMARY KEY (`faktura_spec_id`),
  KEY `tidlog_special_faktura_tidlog_fastighet_FK` (`fastighet_id`),
  CONSTRAINT `tidlog_special_faktura_tidlog_fastighet_FK` FOREIGN KEY (`fastighet_id`) REFERENCES `tidlog_fastighet` (`fastighet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='För egenhändigt komponerade fakturor';