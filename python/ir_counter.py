#!/usr/bin/python
path="/home/pi/iBin/ir/"


fe=open(path+'ir_errorlog.txt','a')




from serial import Serial
from time import time

import os
import MySQLdb as db 
import glob

HOST = '10.16.35.177'
USER = 'ibin'
PASSWORD = 'raspberry'
DATABASE = 'ibin'

#path="/home/pi/iBin/ir"
while True:
	try:
		con = db.connect(HOST,USER,PASSWORD,DATABASE)
		cur = con.cursor()
		break
	except:
		fe.write('db error')	
		continue

#fp=open(path+'ww','w')
#fp.write('ssss')
#fp.flush()
#fp.close()
'''
#path='/home/pi/iBin/ir/'
##import glob
#port=glob.glob('/dev/ttyACM*')
#sa=open('/home/pi/ab.txt','a')
#sa.write(str(len(port))+'\n')
#sa.close()
'''
port = glob.glob('/dev/ttyACM*')
if len(port)<1:
	print("port not found")
#	fe=open(path+'ir_errorlog.txt','a')
	fe.write('port not found')
	fe.close()
	os._exit(1)
'''
#s=Serial(port[0])
#f=open(path+'data_log.txt','a')
#f.write('####')
#while True:
#	val= "%s,%d\n" %(s.readline().rstrip(),int(time()))
#	f.write(val)
#	f.flush()
#	print(val)
	
'''
data_file=open(path+'data_log.txt','a')
def dataRead(ser):
#	print 'b'
	while True:
#		print  'c'
		data = ser.readline()
		data_file.write(data)
		data_file.flush()
#		print 'd'
		data_parts = data.strip()
		print int(data_parts)
		sql = 'insert into student values(NOW(),5,%d)' %(int(data_parts))
		try:
			cur.execute(sql)
			con.commit()
		except:
			con.rollback()
			
	


port = glob.glob('/dev/ttyACM*')
ser = Serial(port[0])
dataRead(ser)
data_file.close()
