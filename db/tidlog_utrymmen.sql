-- tidlog.tidlog_utrymmen definition

CREATE TABLE `tidlog_utrymmen` (
  `vind_id` int NOT NULL AUTO_INCREMENT,
  `nummer` varchar(100) NOT NULL,
  `kommentar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`vind_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

ALTER TABLE tidlog_utrymmen ADD VindTyp varchar(20) NOT NULL;
ALTER TABLE tidlog_utrymmen ADD fastighet_id INT NULL;

insert into tidlog_utrymmen (nummer, VindTyp) values('801', 'Källare'); 
insert into tidlog_utrymmen (nummer, VindTyp) values('802', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('803', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('804', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('805', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('806', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('811', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('812', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('813', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('814', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('815', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('816', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('821', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('822', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('823', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('824', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('825', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('826', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('831', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('832', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('833', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('834', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('835', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('836', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('841', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('842', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('843', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('844', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('845', 'Källare');
insert into tidlog_utrymmen (nummer, VindTyp) values('846', 'Källare');

insert into tidlog_utrymmen (nummer, VindTyp) values('801', 'Vind'); 
insert into tidlog_utrymmen (nummer, VindTyp) values('802', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('803', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('804', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('805', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('806', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('811', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('812', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('813', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('814', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('815', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('816', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('821', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('822', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('823', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('824', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('825', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('826', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('831', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('832', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('833', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('834', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('835', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('836', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('841', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('842', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('843', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('844', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('845', 'Vind');
insert into tidlog_utrymmen (nummer, VindTyp) values('846', 'Vind');

