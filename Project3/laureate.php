


<!DOCTYPE html>
<html>
<body style="font-family:'Arial, sans-serif'">

<H1 align="center">  Project 3: Nobel Laureate's JSON data </H1>

<ul>
    <h3> Student Info: </h3>
    <ul>
        <p>Dhanush Nadella 
        <br>UID: 205150583
        <br>Professor Cho <p>
    </ul>
</ul>



<ul>
    <h3> Description: </h3>
    <ul>
        <p>
        The appropriate JSON data will be outputted given the laureate's ID number.
        <p>
    </ul>

    <h3> JSON data: </h3>
    <ul>
        <form action='laureate.php' method="GET"><INPUT TYPE="hidden" NAME="id" VALUE=""> </form>
        <?php
            $hostname = "localhost";
            $username = "cs143";
            $password = "";
            $db = "cs143";

            $dbconnect=mysqli_connect($hostname,$username,$password,$db);

            if ($dbconnect->connect_error) {
                die("Database connection failed: " . $dbconnect->connect_error);
            }

            $laureate_id = $_GET['id'];

            if (!empty($_GET)){
                echo "{ <ul>";
                    echo '"id":"'.$laureate_id.'",<br>';
                    $query_1 = "SELECT givenName, familyName, gender 
                                FROM Laureates
                                WHERE id = $laureate_id;";
                    $result_1 = $dbconnect->query($query_1);
                    if (mysqli_num_rows($result_1) > 0) {
                        while($row = $result_1->fetch_assoc()){
                            echo '"givenName":{ "en":"'.$row["givenName"].'" },<br>';
                            if (!is_null($row["familyName"])){
                                echo '"familyName":{ "en":"'.$row["familyName"].'" },<br>';
                            }
                            echo '"gender":"'.$row["gender"].'",<br>';
                        }
                    }

                    $query_2 = "SELECT birthDate, city, country
                                FROM LaureateBirth 
                                WHERE id = $laureate_id;";
                    $result_2 = $dbconnect->query($query_2);
                    if (mysqli_num_rows($result_2) > 0) {
                        while($row = $result_2->fetch_assoc()){
                            if (is_null($row["birthDate"]) && is_null($row["city"]) && is_null($row["country"])){
                                break;
                            }
                            else {
                                echo '"birth":{ <br> <ul>';
                                    echo '"date":"'.$row["birthDate"].'", <br>';
                                    echo '"place":{ <br> <ul>';
                                        if (!is_null($row["city"])){
                                            echo '"city":{ "en":"'.$row["city"].'" }, <br>';
                                        }
                                        echo '"country":{ "en":"'.$row["country"].'" } <br> </ul>';
                                    echo "} <br> </ul>";
                                echo "}, <br>";
                            }
                        }
                    }

                    $query_3 = "SELECT orgName, foundedDate, city, country
                                FROM OrgLaureates
                                WHERE id = $laureate_id;";
                    $result_3 = $dbconnect->query($query_3);
                    if (mysqli_num_rows($result_3) > 0){
                        while ($row = $result_3->fetch_assoc()){
                            echo '"orgName":{ "en":"'.$row["orgName"].'" }, <br>';
                            if (is_null($row["foundedDate"]) && is_null($row["city"]) && is_null($row["country"])){
                                break;
                            }
                            else {
                                echo '"founded": { <br> <ul>';
                                    if (is_null($row["city"]) && is_null($row["country"])){
                                        echo '"date":"'.$row["foundedDate"].'" <br> </ul>';
                                        echo "}, <br>";
                                        break;
                                    }
                                    else{
                                        echo '"date":"'.$row["foundedDate"].'", <br>';
                                        echo '"place": { <br> <ul>';
                                        if (!is_null($row["city"])){
                                            echo '"city":{ "en":"'.$row["city"].'" }, <br>';
                                        }
                                        if (!is_null($row["country"])){
                                            echo '"country":{ "en":"'.$row["country"].'" } <br> </ul>';
                                        }
                                        echo "} <br> </ul>";
                                    }
                                echo "}, <br>";
                            }
                        }
                    }

                    $query_4 = "SELECT DISTINCT awardYear, category, sortOrder, portion, prizeStatus,
                                       dateAwarded, motivation, prizeAmount
                                FROM LaureatePrizes
                                WHERE id = $laureate_id;";

                    $result_4 = $dbconnect->query($query_4);
                    if (mysqli_num_rows($result_4) > 0){
                        echo '"nobelPrizes":[ <br><ul>';
                        $nobelprize_counter = 0;
                        while($row = $result_4->fetch_assoc()){
                            echo '{ <br> <ul>';
                            echo '"awardYear":"'.$row["awardYear"].'", <br>';
                            echo '"category":{ "en":"'.$row["category"].'" }, <br>';
                            echo '"sortOrder":"'.$row["sortOrder"].'", <br>';
                            echo '"portion":"'.$row["portion"].'", <br>';
                            if (!is_null($row["dateAwarded"])){
                                echo '"dateAwarded":"'.$row["dateAwarded"].'", <br>';
                            }
                            echo '"prizeStatus":"'.$row["prizeStatus"].'", <br>';
                            echo '"motivation":{ "en":"'.$row["motivation"].'" }, <br>';
                            echo '"prizeAmount":'.$row["prizeAmount"];


                            $query_5 = 'SELECT affilName, affilCity, affilCountry
                                        FROM LaureatePrizes
                                        WHERE id = '.$laureate_id.' AND awardYear = '.$row["awardYear"].';';
                            
                            $result_5 = $dbconnect->query($query_5);
                            if (mysqli_num_rows($result_5) > 0){
                                if (mysqli_num_rows($result_5) == 1){
                                    $row_2 = $result_5->fetch_assoc();
                                    if (is_null($row_2["affilName"]) && is_null($row_2["affilCity"]) && is_null($row_2["affilCountry"])){
                                        if (++$nobelprize_counter == mysqli_num_rows($result_4)){
                                            echo "</ul>";
                                            echo "} <br>";
                                        }
                                        else {
                                            echo "</ul>";
                                            echo "}, <br>";
                                        }
                                        continue;
                                    }
                                    echo ', <br>';
                                    echo '"affiliations":[<br><ul>';
                                    echo "{ <br> <ul>";
                                        echo '"name":{ "en":"'.$row_2["affilName"].'" }';
                                        if (!is_null($row_2["affilCity"])){
                                            echo ', <br>';
                                            echo '"city":{ "en":"'.$row_2["affilCity"].'" }';
                                        }
                                        if (!is_null($row_2["affilCountry"])){
                                            echo ', <br>';
                                            echo '"country":{ "en":"'.$row_2["affilCountry"].'" }<br>';
                                        }
                                    echo "</ul>";
                                    echo "} <br>";
                                    echo "</ul>";
                                    echo "] <br>";
                                }
                                else {
                                    echo ', <br>';
                                    echo '"affiliations":[<br><ul>';
                                    $affiliation_counter = 0;
                                    while ($row_2 = $result_5->fetch_assoc()){
                                        echo "{ <br> <ul>";
                                        echo '"name":{ "en":"'.$row_2["affilName"].'" }';
                                        if (!is_null($row_2["affilCity"])){
                                            echo ', <br>';
                                            echo '"city":{ "en":"'.$row_2["affilCity"].'" }';
                                        }
                                        if (!is_null($row_2["affilCountry"])){
                                            echo ', <br>';
                                            echo '"country":{ "en":"'.$row_2["affilCountry"].'" }<br>';
                                        }
                                        if (++$affiliation_counter == mysqli_num_rows($result_5)){
                                            echo "</ul>";
                                            echo "}";
                                        }
                                        else{
                                            echo "</ul>";
                                            echo "}, <br>";
                                        }
                                    }
                                    echo "</ul>";
                                    echo "]<br>";
                                }
                            }
                            if (++$nobelprize_counter == mysqli_num_rows($result_4)){
                                echo "</ul>";
                                echo "} <br>";
                            }
                            else {
                                echo "</ul>";
                                echo "}, <br>";
                            }
                        }
                        echo "</ul>";
                        echo "]";
                    }
                echo "</ul>";
                echo "}";
            }
            $result_1->free();
            $result_2->free();
            $result_3->free();
            $result_4->free();
            $result_5->free();
            $dbconnect->close();
        ?>
    
    </ul>
</ul>

</body>
</html>


