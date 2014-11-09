import glob 
import MySQLdb as  db

from serial import Serial
from time import time

HOST = "10.16.35.177"
USER = "ibin"
PASSWORD = "raspberry"
DB = "ibin"

while True:
	try:
		conn = db.connect(HOST,USER,PASSWORD,DB)
		cur = conn.cursor()
		break
	except:
		continue

def readData(serial_handler):
	while True:
		data = serial_handler.readline()
		data_parts = data.strip().split('|')
		
		print data,int(time())

		
		if len(data_parts) == 4:
			if data_parts[2] == 'positive':
				#print data_parts[3], int(time())
								
				sql  = "insert into waste values( NOW(),1,5,%f)" %((float(data_parts[3])))
				try:
					cur.execute(sql)
					conn.commit()
				except:
					conn.rollback()
			
			else:
				pass
				#don't do anything
		elif len(data_parts) == 3 and data_parts[2] !='setup':
			print data_parts[0],data_parts[1],int(time())
		else:
			print data
		
if __name__ == '__main__':
	arduPort  = glob.glob('/dev/ttyACM*')
	ser = Serial(arduPort[0])
	readData(ser)
