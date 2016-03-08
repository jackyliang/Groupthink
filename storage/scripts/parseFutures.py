#!/usr/bin/python
import Quandl
import time
import os
import MySQLdb as mdb

token = "HR3bqCRVRrowVExZCrEX"
exchange = "CME"
symbols = ["CLF2016", "CLG2016", "CLH2016"]

# TODO: replace hardcoded MySQL connection string with 
# environment variables

con = mdb.connect('localhost', 'homestead', 'secret', 'homestead');
with con: #this creates the two tables, symbols and prices, and drops them if they already exist
	cur = con.cursor()

sql = "SELECT * FROM Symbols WHERE type='future'"
cur.execute(sql)
symbols = cur.fetchall()

for row in symbols:
	print row
	symbolId = row[0]
	exchange = row[1]
	symbol = row[2]
	futureType = row[3]
	futureCat  = row[4]
	expireMonth = row[5]
	expireYear = row[6]
	currentTime = time.strftime('%Y-%m-%d %H:%M:%S')
	
	##first we have to make sure the symbol is in the parent table (Symbols) or inserts into the child (Prices) will fail
	#sql = "INSERT INTO Symbols(exchange, symbol, type, cat, expire_month, expire_year, updated) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s') ON DUPLICATE KEY UPDATE exchange=VALUES(exchange), type=VALUES(type), cat=VALUES(cat), expire_month=VALUES(expire_month), expire_year=VALUES(expire_year), updated=VALUES(updated)" % \
	#(exchange, symbol, futureType, futureCat, expireMonth, expireYear, stillUpdated)
	#cur.execute(sql)
	
	myData = Quandl.get(exchange + "/" + symbol, authtoken=token)
	for index, row in myData.iterrows():
		#print(row.Open, row.High)
		#print index
		sql = "INSERT INTO Prices(date, symbol_id, open, high, low, last, settle, volume, created_at, updated_at) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ON DUPLICATE KEY UPDATE symbol_id=VALUES(symbol_id), open=VALUES(open), high=VALUES(high), low=VALUES(low), last=VALUES(last), settle=VALUES(settle), volume=VALUES(volume), updated_at=NOW()" % \
		(index, symbolId, row.Open, row.High, row.Low, row.Last, row.Settle, row.Volume, currentTime, currentTime)
		#print sql
		cur.execute(sql)

		#sql = "INSERT INTO Prices(date, open, high, low, last, settle, volume) VALUES ('2015-10-22 00:00:00', '48.06', '48.18', '47.08', '47.34', '47.35', '34628.0') ON DUPLICATE KEY UPDATE "
		#print sql
		#cur.execute(sql)
		
		#print row['timestamp']
		#print dir(row)
		#sys.exit()
		pass
	con.commit()
#print myData
