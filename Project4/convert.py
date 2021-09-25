import json

import_file = open("laureates.import","w")


with open("/home/cs143/data/nobel-laureates.json",'r') as json_file:
# with open("nobel-laureates.json",'r') as json_file:
    laureate_dict = json.load(json_file)

laureate_list = laureate_dict['laureates']


for laureate in laureate_list:
    print(json.dumps(laureate, indent=4), file=import_file)