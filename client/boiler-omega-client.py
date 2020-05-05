# /usr/bin/env python

import time
import datetime
import onionGpio
import requests
import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)


#Configure switch pin
switch_pin = 0
switch_obj  = onionGpio.OnionGpio(switch_pin)
status_switch = switch_obj.setInputDirection()

#Configure contactor pin
contact_pin = 3
contact_obj  = onionGpio.OnionGpio(contact_pin)
status_contact = contact_obj.setOutputDirection(1)
print "Status Contact: "+str(status_contact)

auto_off = 45 # Auto off after X min


# Switch class object.
class toggle(object):
    def __init__(self, val=False):
        self._on = val

    def toggle_on(self):
        if not self._on:
            contact_obj.setValue(0)
            print "Boiler on"
            self._on = True
            telegram_bot_sendtext("\xF0\x9F\x94\xA5 Boiler On \xF0\x9F\x94\xA5")

    def toggle_off(self,start_on=None):
        if self._on:
            print "Boiler off"
            contact_obj.setValue(1)
            self._on = False
            telegram_bot_sendtext("\xF0\x9F\x9A\xA8 Boiler Off \xF0\x9F\x9A\xA8")
            delta = datetime.datetime.now() - start_on
            telegram_bot_sendtext("\xE2\x8F\xB0 The Boiler Was ON For "+str(delta.seconds/60)+" minutes \xE2\x8F\xB0")

# Function to get the current status from the website
def get_status():
    try:
        url = "https://boiler.example.com/api.php?status=status"
        response = requests.get(url, auth=(<web_user>, <web_password>), verify=False)
        data = response.json()
        api = data["data"]
        return (api)
    except:
        return (False)


# Function to update the website when timer is done
def send_off():
    try:
        off = requests.post('https://boiler.example.com/server.php', auth=(<web_user>, <web_password>), verify=False, data={'off':'off'})
    except:
        print "Cannot update website that i am turning off the switch"


def send_hb():
    try:
        requests.post('https://boiler.example.com/api.php?hb=1', auth=(<web_user>, <web_password>), verify=False)
    except:
        print "Cant send HB"

# Send notification in Telegram
def telegram_bot_sendtext(bot_message):
    
    bot_token = <TELEGRAM-BOT-TOKEN>
    bot_chatID = <TELEGRAM-BOT-CHATID>
    send_text = 'https://api.telegram.org/bot' + bot_token + '/sendMessage?chat_id=' + bot_chatID + '&parse_mode=Markdown&text=' + bot_message
    try:
        response = requests.get(send_text)
    except:
        print "Cannot connect to Internet"

boiler = toggle()

# Main Loop
while True:

    send_hb()
    api = get_status()
    if api == 'green':
        start_on = datetime.datetime.now()
        timeout = time.time() + (auto_off*60)
        boiler.toggle_on()                  # Turn the boiler on
        while timeout > time.time():        # Loop to check while the counter is running
            time.sleep(8)
            api = get_status()
            send_hb()
            if api == 'red':
                boiler.toggle_off(start_on)
                break
        boiler.toggle_off(start_on)         # Turn the boiler off at the end of the time
	if timeout <= time.time():
            send_off()              # update the website that it off


    else:
        boiler.toggle_off()




    time.sleep(8)

