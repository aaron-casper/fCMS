#this is the dirt-simple content-injector
# "How do I use this?":
# run this script in the same local dir as post.txt
# it reads that file and injects the contents
# after prompting the user for a title
# pretty crude, but it works
# -floz

import sys
import sqlite3
print("title: ")			#prompt for title
title = sys.stdin.readline()
readFile = open("post.txt","r")		#read post.txt in
body=""					#set up variable for long string
for line in readFile:			#iterate through post.txt line-by-line
    body = body + "<BR>" + line		#add HTML tags at the end of each line

print("\n-----\n" + title + "\n-----\n")		#"prettify" the output
body = body.replace('\n','')				#replace carriage return chars with null
body = body.replace('\r','')				#ditto
print(body + "\n-----\n")				#"prettify" the output
raw_input("enter to commit -or- ctrl+c to quit")	#ask, "are you sure?"
print("opening db")					#notify user that we're opening the database
conn = sqlite3.connect('./html/db/content.db')		#open the database
print("db opened")					#notify the user of success, note no error-detection, if it fails, it's terminal here


try:				#error handler, yay!
    print("insert into 'posts'...")							#user notification
    conn.execute("INSERT INTO 'posts' (title,body) VALUES (?,?);",(title,body))		#insert into DB
    conn.commit()									#commit DB
    print("INSERT INTO 'posts' (title,body) VALUES (?,?);",(title,body))		#show user exactly what happened
except Exception as e:		#if it didn't work
    print(e)			#tell the user why
print("closing db")		#tell the user we're closing the DB
conn.close()			#close the DB
quit()				#end
