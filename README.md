# Home - Raspberry Pi Zero W Temperature Sensor

<strong>Materials:</strong><br />
Raspberry Pi Zero W<br />
DHT22 temperature and humidity sensor<br />
Somewhere to host your api

<strong>Guide:</strong><br />
1. Configure your Raspberry Pi by following an online tutorial.
2. Login to your Pi using ssh e.g. ssh pi@192.168.0.38 password raspberry (default).
3. Upload the temperature and humdity recording software tempsensor.py.
4. Now upload launcher.sh and follow the tutorial by instructables to launch tempsensor.py on start up (https://www.instructables.com/id/Raspberry-Pi-Launch-Python-script-on-startup/).
5. Reboot your Pi (sudo reboot) and that's it!

<strong>What's going on?</strong><br />
Once your Raspberry Pi loads up launcher.sh will run and that will open tempsensor.py automatically. tempsensor.py will sleep for 10 seconds and then fire to your api every 30 seconds (you can change this by amending the sleep functionality (time.sleep(SECONDS)). If your Pi stops firing to the api a simple reboot is required.
