delete from tidlog_faktura where faktura_id in (
SELECT t.faktura_id from tidlog_faktura t 
inner join tidlog_lagenhet l on t.lagenhet_id = l.lagenhet_id
inner join tidlog_fastighet f on f.fastighet_id = l.fastighet_id
where t.faktura_month = 4 and f.fastighet_id = 1)
