#!/usr/bin/env python

import RPi.GPIO as GPIO
from gpiozero import Button, Buzzer
from time import sleep
from mfrc522 import SimpleMFRC522
import pandas as pd
import sys
import base64
from datetime import datetime

# datetime object containing current date and time
# now = datetime.now()

# date_time_now = now.strftime("%d/%m/%Y %H:%M:%S")
# print("date_time_now")

def test_csv():
    df = pd.DataFrame({'Time': ["aaa"],
                       'ID': ["this is id"],
                       'Description': ["description"]})
    
    #view DataFrame
    print("---This is what to add--- ")
    print(df)



def write_only():
    # id = "123"
    # oldText = "000"
    
    #read current data
    id, oldText = reader.read()
    buzzer.beep(0.1, 0.1, 1)

    
    #key in new data
    text = input("New data:")
    print("Now place your tag to write")
    buzzer.beep(0.1, 0.1, 1)
    
    #encrypt the new data
    convert2byte = bytes(text,encoding="utf-8")    
    encoded_data_in_byte = base64.b64encode(convert2byte)
    #convert data into string type so able to write    
    final_encode_data_in_str = encoded_data_in_byte.decode('UTF-8')
    print("---New Data---\n" + "Text: " + final_encode_data_in_str)
    
    #write the new_encrypted_data
    reader.write(final_encode_data_in_str)
    
    #record to database
    now = datetime.now()
    date_time_now = now.strftime("%d/%m/%Y %H:%M:%S")
    
    df = pd.DataFrame({'Time': [date_time_now],
                       'ID': [id],
                       'Description': [final_encode_data_in_str]})
    
    #view DataFrame
    print("---This is what to add--- ")
    print(df)
    
    df.to_csv('database.csv', mode='a', index=False, header=False)
    
    df.to_csv('what2add.csv', mode='w', index=False, header=True)

def read_and_record_to_database():
    
    #read current data
    id, oldText = reader.read()
    buzzer.beep(0.1, 0.1, 1)
    pre_decode = oldText.encode('UTF-8')  #change to bytes
    decoded_data = base64.b64decode(pre_decode)  #must decode in byte format
    final_decoded_data = decoded_data.decode('UTF-8')
    
    print("---Detected Data---\n" + "ID: %s\nText: %s" % (id,final_decoded_data))

    #record to database
    now = datetime.now()
    date_time_now = now.strftime("%d/%m/%Y %H:%M:%S")
    
    df = pd.DataFrame({'Time': [date_time_now],
                       'ID': [id],
                       'Description': [oldText]})
    
    #view DataFrame
    print("---This is what to add--- ")
#     print(df)
    
    df.to_csv('database.csv', mode='a', index=False, header=True)
    
    df.to_csv('what2add.csv', mode='w', index=False, header=True)
    
    dataframe.to_csv('database.csv', 
                     index = False)
    print(dataframe)

def read_and_update():
    
    # id = "123"
    # oldText = "000"
    
    #read current data
    id, oldText = reader.read()
    buzzer.beep(0.1, 0.1, 1)
    pre_decode = oldText.encode('UTF-8')  #change to bytes
    decoded_data = base64.b64decode(pre_decode)  #must decode in byte format
    final_decoded_data = decoded_data.decode('UTF-8')
    
    print("---Old Data---\n" + "ID: %s\nText: %s" % (id,final_decoded_data))
    
    #key in new data
    text = input("New data:")
    print("Now place your tag to write")
    buzzer.beep(0.1, 0.1, 1)
    
    #encrypt the new data
    convert2byte = bytes(text,encoding="utf-8")    
    encoded_data_in_byte = base64.b64encode(convert2byte)
    #convert data into string type so able to write    
    final_encode_data_in_str = encoded_data_in_byte.decode('UTF-8')
    print("---New Data---\n" + "Text: " + final_encode_data_in_str)
    
    #write the new_encrypted_data
    reader.write(final_encode_data_in_str)
    
    # replace new data to existing csv
    # making data frame from the csv file 
    dataframe = pd.read_csv("database.csv")
    a = str.strip(oldText)

    print(a)
    print("This is the old csv:")
    print(dataframe)    
     # using the replace() method
    dataframe.replace(to_replace = a, 
                     value = final_encode_data_in_str, 
                      inplace = True)
    
    dataframe.to_csv('database.csv', 
                     index = False)
    
    dataframe = pd.read_csv("database.csv")
    print("This is the new csv:")
    print(dataframe)
    
    #This part is to generate csv for what had changes
    now = datetime.now()
    date_time_now = now.strftime("%d/%m/%Y %H:%M:%S")
    
    df = pd.DataFrame({'Time': [date_time_now],
                       'ID': [id],
                       'Description': [final_encode_data_in_str]})

    df.to_csv('what2replace.csv', mode='w', index=False, header=True)
    
    
# def encrypt():

#     convert2byte = bytes("encrypt this message",encoding="utf-8")
    
#     encoded_data = base64.b64encode(convert2byte)
    
#     pre_encode = encoded_data.decode('UTF-8')
#     print(pre_encode)
    

def only_read_and_decrypt():
    #!!! NO RECORD!!!
    #read current data
    id, oldText = reader.read()
    buzzer.beep(0.1, 0.1, 1)
    pre_decode = oldText.encode('UTF-8')  #change to bytes
    decoded_data = base64.b64decode(pre_decode)  #must decode in byte format
    final_decoded_data = decoded_data.decode('UTF-8')
    
    print("---Detected Data---\n" + "ID: %s\nText: %s" % (id,final_decoded_data))
    print(id,oldText)

    
    
GPIO.setwarnings(False)

sw1 = Button(21)
sw2 = Button(16)
sw3 = Button(20)
buzzer = Buzzer(26)

reader = SimpleMFRC522()

buzzer.beep(0.1, 0.1, 2)

try:
    while True:
        #read tag
        if sw1.is_pressed:
            print("Hold a tag near the reader")
#             read_and_record_to_database()
            write_only()
            
        elif sw2.is_pressed:
            print("Hold a tag near the reader")
            read_and_update()
        
        elif sw3.is_pressed:
            print("Hold a tag near the reader")
            only_read_and_decrypt()
#             reader.write("dGVzdGluZw==")
        #     print("ID: %s\nText: %s" % (id,oldText))
        #     text = input('New data:')
        #     print("Now place your tag to write")
        #     #reader.write(text)
        #     buzzer.beep(0.1, 0.1, 1)
        #     update()
        #     #print(oldText +',new Text ='+ text)
        #     print("Written")
        #     print()
            

except KeyboardInterrupt:
    GPIO.cleanup()
    raise

