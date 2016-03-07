#!/usr/bin/python
import MySQLdb as mdb
import urllib2
import json

baseUrl = "https://api.stocktwits.com/api/2/streams/symbol/"
urlSuffix = ".json"

con = mdb.connect('localhost', 'homestead', 'secret', 'homestead');
with con: #this creates the two tables, symbols and prices, and drops them if they already exist
	cur = con.cursor()
	sql = "SELECT * FROM Symbols WHERE type='index'"
	cur.execute(sql)
	symbols = cur.fetchall()


for row in symbols:
	dbID = row[0]
	exchange = row[1]
	symbol = row[2]
	futureType = row[3]
	futureCat  = row[4]
	expireMonth = row[5]
	expireYear = row[6]
	#stillUpdated = row[7]
	url = baseUrl + symbol + urlSuffix
	#https://api.stocktwits.com/api/2/streams/symbol/AAPL.json
	
	data = urllib2.urlopen(url).read()
	data = json.loads(data)

	db_symbol_id = data['symbol']['symbol'].encode('utf-8')
	
	for tweet in data['messages']:
		messageId = tweet['id']
		body = tweet['body'].encode('utf-8')
		timestamp = tweet['created_at'].encode('utf-8')
		username = tweet['user']['username'].encode('utf-8')
		symbol_id = db_symbol_id
		
		print("Message ID: " + str(messageId))
		print("Message body: " + str(body))
		print("Message Time: " + str(timestamp))
		print("Message Username: " + str(username))
		print("Symbol: " + str(symbol_id))
		print "\n"
		
		sql = "INSERT INTO Tweets(timestamp, message_id, body, username, symbol_id) VALUES ('%s', '%s', '%s', '%s', '%s') ON DUPLICATE KEY UPDATE timestamp=VALUES(timestamp), message_id=VALUES(message_id), body=VALUES(body), username=VALUES(username), symbol_id=VALUES(symbol_id)"% \
		(timestamp, messageId, body, username, dbID)
		#print sql
		cur.execute(sql)
	con.commit()
		
		
