#!/usr/bin/python
import MySQLdb as mdb
import urllib2
import json
import time

baseUrl = "https://api.stocktwits.com/api/2/streams/symbol/"
urlSuffix = ".json"

# TODO: replace hardcoded MySQL connection string with 
# environment variables
# 
con = mdb.connect('localhost', 'homestead', 'secret', 'homestead');
with con: 
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
	url = baseUrl + symbol + urlSuffix
	# https://api.stocktwits.com/api/2/streams/symbol/AAPL.json
	
	data = urllib2.urlopen(url).read()
	data = json.loads(data)

	db_symbol_id = data['symbol']['symbol'].encode('utf-8')
	
	for tweet in data['messages']:
		messageId = tweet['id']
		body = tweet['body'].encode('utf-8')
		timestamp = tweet['created_at'].encode('utf-8')
		username = tweet['user']['username'].encode('utf-8')
		symbol_id = db_symbol_id
		currentTime = time.strftime('%Y-%m-%d %H:%M:%S')
		
		print("Message ID: " + str(messageId))
		print("Message body: " + str(body))
		print("Message Time: " + str(timestamp))
		print("Message Username: " + str(username))
		print("Symbol: " + str(symbol_id))
		print "\n"
		
		sql = "INSERT INTO Tweets(timestamp, message_id, body, username, symbol_id, created_at, updated_at) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s') ON DUPLICATE KEY UPDATE updated_at=NOW()"% \
		(timestamp, messageId, body, username, dbID, currentTime, currentTime)
		#print sql
		cur.execute(sql)
	con.commit()
		
		
