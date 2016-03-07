import Quandl
import MySQLdb as mdb

token = "HR3bqCRVRrowVExZCrEX"
exchange = "CME"
symbols = ["CLF2016", "CLG2016", "CLH2016"]
#symbol = "CME/CLF2016"

con = mdb.connect('localhost', 'dbuser', 'dbuser', 'mydb');
with con: #this creates the two tables, symbols and prices, and drops them if they already exist
	cur = con.cursor()
	#cur.execute("SET FOREIGN_KEY_CHECKS=0")
	#cur.execute("DROP TABLE IF EXISTS Symbols")
	#cur.execute("DROP TABLE IF EXISTS Prices")
	#cur.execute("SET FOREIGN_KEY_CHECKS=1")
	#cur.execute("CREATE TABLE Symbols( \
	#	exchange TINYTEXT, \
	#	symbol VARCHAR(20) NOT NULL UNIQUE, \
	#	type TINYTEXT, \
	#	cat TINYTEXT, \
	#	expire_month TINYINT, \
	#	expire_year TINYINT, \
	#	updated BOOLEAN, \
	#	PRIMARY KEY (symbol)) ENGINE=InnoDB")
	#
	#cur.execute("CREATE TABLE Prices( \
	#	id INT PRIMARY KEY AUTO_INCREMENT, \
	#	date DATE NOT NULL UNIQUE, \
	#	symbol VARCHAR(20), \
	#	open FLOAT, \
	#	high FLOAT, \
	#	low FLOAT, \
	#	last FLOAT, \
	#	settle FLOAT, \
	#	volume INT, \
	#	FOREIGN KEY (symbol) REFERENCES Symbols(symbol)) ENGINE=InnoDB")


sql = "SELECT * FROM Symbols WHERE type='future'"
cur.execute(sql)
symbols = cur.fetchall()

for row in symbols:
	exchange = row[0]
	symbol = row[1]
	futureType = row[2]
	futureCat  = row[3]
	expireMonth = row[4]
	expireYear = row[5]
	stillUpdated = row[6]
	##first we have to make sure the symbol is in the parent table (Symbols) or inserts into the child (Prices) will fail
	#sql = "INSERT INTO Symbols(exchange, symbol, type, cat, expire_month, expire_year, updated) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s') ON DUPLICATE KEY UPDATE exchange=VALUES(exchange), type=VALUES(type), cat=VALUES(cat), expire_month=VALUES(expire_month), expire_year=VALUES(expire_year), updated=VALUES(updated)" % \
	#(exchange, symbol, futureType, futureCat, expireMonth, expireYear, stillUpdated)
	#cur.execute(sql)
	
	myData = Quandl.get(exchange + "/" + symbol, authtoken=token)
	for index, row in myData.iterrows():
		#print(row.Open, row.High)
		#print index
		sql = "INSERT INTO Prices(date, symbol, open, high, low, last, settle, volume) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ON DUPLICATE KEY UPDATE symbol=VALUES(symbol), open=VALUES(open), high=VALUES(high), low=VALUES(low), last=VALUES(last), settle=VALUES(settle), volume=VALUES(volume)" % \
		(index, symbol, row.Open, row.High, row.Low, row.Last, row.Settle, row.Volume)
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
