import re
import glob
from bs4 import BeautifulSoup

for file in sorted(glob.glob('*.snapshot')):

    puerto = open(file)
    soup = BeautifulSoup(puerto, 'html.parser')

    for percent in soup.find_all("progress", { "class" : "progress" }):
        print file + ", " + percent["value"]
