import sys
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import time

contact_name = sys.argv[1]
message = sys.argv[2]

driver = webdriver.Chrome(executable_path='/path/to/chromedriver')  # Ganti dengan path ke ChromeDriver
driver.get('https://web.whatsapp.com')

input('Scan QR code and press Enter')

search_box = driver.find_element_by_xpath('//div[@contenteditable="true"][@data-tab="3"]')
search_box.send_keys(contact_name)
search_box.send_keys(Keys.ENTER)
time.sleep(2)

message_box = driver.find_element_by_xpath('//div[@contenteditable="true"][@data-tab="6"]')
message_box.send_keys(message)
message_box.send_keys(Keys.ENTER)

print('Message sent successfully.')
driver.quit()
