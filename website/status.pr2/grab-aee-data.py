import re
import glob
from bs4 import BeautifulSoup

for file in sorted(glob.glob('*.snapshot')):

    puerto = open(file)
    soup = BeautifulSoup(puerto, 'html.parser')

    for percent in soup.find_all("div", { "class" : "info-aee" }):
        tempText = percent("progress")[0]
        print "Date: " + file + ", Percent: " + tempText['value']
