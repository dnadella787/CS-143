#REMEMBER TO CHANGE THE PATH FOR THE JSON FILE BEFORE SUBMISSION 
#things to do:


import json

laureates_del = open("laureates.del","w")
orglaureates_del = open("org_laureates.del", "w")
laureatebirth_del = open("laureate_birth.del", "w")
laureateprize_del = open("laureate_prize.del", "w")

with open("/home/cs143/data/nobel-laureates.json",'r') as json_file:
    laureate_dict = json.load(json_file)

laureate_list = laureate_dict['laureates']

# keys for normal person:
#['id', 'knownName', 'givenName', 'familyName', 
#'fullName', 'gender', 'birth', 'links', 'nobelPrizes']

#keys for org:
#['id', 'orgName', 'nativeName', 'founded', 'links', 'nobelPrizes'])

for laureate in laureate_list:
    #parse all normal people laureates
    if "orgName" not in laureate.keys():
        #fill out laureates.del
        id = laureate["id"]
        given_name = '"{}"'.format(laureate["givenName"]["en"])
        if "familyName" not in laureate.keys():
            family_name = "\\N"
        else:
            family_name = '"{}"'.format(laureate["familyName"]["en"])
        gender = laureate["gender"]

        print("{},{},{},{}".format(id, given_name, family_name, gender), file = laureates_del)


        #fill out laureate_birth.del
        if "birth" not in laureate.keys():
            date = "\\N"
            city = "\\N"
            country = "\\N"
        else:
            date = laureate["birth"]["date"]
            if "city" not in laureate["birth"]["place"].keys():
                city = "\\N"
            else:
                city = '"{}"'.format(laureate["birth"]["place"]["city"]["en"])
            
            country = '"{}"'.format(laureate["birth"]["place"]["country"]["en"])

        print("{},{},{},{}".format(id, date, city, country), file = laureatebirth_del)


        
    #parse all organizations
    else:
        #fill out org_laureates.del
        id = laureate["id"]
        org_name = '"{}"'.format(laureate["orgName"]["en"])
        if "founded" not in laureate.keys():
            date = "\\N"
            city = "\\N"
            country = "\\N"
        else:
            date = laureate["founded"]["date"]

            if "city" not in laureate["founded"]["place"].keys():
                city = "\\N"
            else:
                city = '"{}"'.format(laureate["founded"]["place"]["city"]["en"])

            if "country" not in laureate["founded"]["place"].keys():
                country = "\\N"
            else:
                country = '"{}"'.format(laureate["founded"]["place"]["country"]["en"])

        
        print("{},{},{},{},{}".format(id, org_name, date, city, country), file = orglaureates_del)


    for prize in laureate["nobelPrizes"]:
        id = laureate["id"]
        award_year = prize["awardYear"]
        category = '"{}"'.format(prize["category"]["en"])
        sort_order = prize["sortOrder"]
        portion = prize["portion"]
        prize_status = prize["prizeStatus"]

        if "dateAwarded" not in prize.keys():
            date_awarded = "\\N"
        else:
            date_awarded = prize["dateAwarded"]

        motivation = '"{}"'.format(prize["motivation"]["en"])
        prize_amount = prize["prizeAmount"]

        if "affiliations" not in prize.keys():
            name = "\\N"
            city = "\\N"
            country = "\\N"
            print("{},{},{},{},{},{},{},{},{},{},{},{}".format(id, 
                                                               award_year,
                                                               category,
                                                               sort_order,
                                                               portion,
                                                               prize_status,
                                                               date_awarded,
                                                               motivation,
                                                               prize_amount,
                                                               name,
                                                               city,
                                                               country),
                                                               file = laureateprize_del)
        else:
            for affiliation in prize["affiliations"]:
                name = '"{}"'.format(affiliation["name"]["en"])

                if "city" not in affiliation.keys():
                    city = "\\N"
                else:
                    city = '"{}"'.format(affiliation["city"]["en"])

                if "country" not in affiliation.keys():
                    country = "\\N"
                else:
                    country = '"{}"'.format(affiliation["country"]["en"])
                
                print("{},{},{},{},{},{},{},{},{},{},{},{}".format(id, 
                                                                   award_year,
                                                                   category,
                                                                   sort_order,
                                                                   portion,
                                                                   prize_status,
                                                                   date_awarded,
                                                                   motivation,
                                                                   prize_amount,
                                                                   name,
                                                                   city,
                                                                   country),
                                                                   file = laureateprize_del)

json_file.close()
laureates_del.close()
orglaureates_del.close()
laureatebirth_del.close()
laureateprize_del.close()



            
        

        



    

