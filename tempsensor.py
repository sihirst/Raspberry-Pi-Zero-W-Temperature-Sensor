#!/usr/bin/env python
import sys
import RPi.GPIO as GPIO
import Adafruit_DHT
import time
import requests
import urllib3
GPIO.setmode(GPIO.BCM)
# Setup RED LED (read Data indication)
RedLedPin = 17
GPIO.setup(RedLedPin, GPIO.OUT)
GPIO.output(RedLedPin, GPIO.HIGH)
# Setup GREEB LED (send Data)
GreenLedPin = 27
GPIO.setup(GreenLedPin, GPIO.OUT)
GPIO.output(GreenLedPin, GPIO.HIGH)
# Setup sensor
# Setup DHT22 1
sensorId1 = 'aw4o5n7w'
sensor1 = Adafruit_DHT.DHT22
DataPin1 = 4
# Setup DHT22 2
sensorId2 = 'bw4o5n7w'
sensor2 = Adafruit_DHT.DHT22
DataPin2 = 24
# Setup HTTP Request
url = 'https://example.com/api.php'
http = urllib3.PoolManager()
metric = 'temperature'
key = '4781e8063e7d2'
# Qckm Settings
# 
GPIO.output(RedLedPin, GPIO.LOW)
GPIO.output(GreenLedPin, GPIO.LOW)
time.sleep(5)
GPIO.output(RedLedPin, GPIO.HIGH)
GPIO.output(GreenLedPin, GPIO.HIGH)
time.sleep(5)
while True:
    try:
        # Read data
        GPIO.output(RedLedPin, GPIO.LOW)
        humidity1, temperature1 = Adafruit_DHT.read_retry(sensor1, DataPin1)
        print('Sensor 1: Temperature: {0:0.1f}*C Humidity: {1:0.1f}%'.format(te$
        # Send data
        GPIO.output(GreenLedPin, GPIO.LOW)
        #r = http.request('POST',
        #url,
        #fields={'m': metric, 'k': key, 'v': 1})
        payload = {'k': '4781e8063e7d2','t': temperature1, 'h': humidity1}
        r = requests.post('https://example.com/api.php', params=payload)
        #print(r.data)
        GPIO.output(GreenLedPin, GPIO.HIGH)
        time.sleep(30)
    except ValueError:
        GPIO.output(RedLedPin, GPIO.HIGH)
        GPIO.output(GreenLedPin, GPIO.HIGH)
        print('Sensor 1: Error reading data')
    except KeyboardInterrupt:
        GPIO.output(RedLedPin, GPIO.HIGH)
        GPIO.output(GreenLedPin, GPIO.HIGH)
        GPIO.cleanup()
