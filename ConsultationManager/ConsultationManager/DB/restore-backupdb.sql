RESTORE DATABASE [consultation_db] FROM DISK = 'tmp/master.bak'
WITH FILE = 1,
MOVE 'consultation_db' TO '/var/opt/mssql/data/consultation_db.mdf',
MOVE 'consultation_db_log' TO '/var/opt/mssql/data/consultation_db_log.ldf',
NOUNLOAD, REPLACE, STATS=5
GO