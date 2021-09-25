<!DOCTYPE html>
<html>
<body>

<H1 align="center"> Search Page </H1>


<nav>
  <ul>
  <h3> Navigation </h3>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><strong>Search Actor/Movie</strong></li>
        <li><a href="actorinfo.php?actor=52794">Actor Information Page</a></li>
        <li><a href="movieinfo.php?movie=2632">Movie Information Page</a></li>
        <li><a href="reviews.php?review=2632">Add Movie Review</a></li>
    </ul>
  </ul>
</nav>



<ul>
    <h3> Description: </h3>
    <ul>
        <p>You can search for a movie or an actor/actress here using keywords. 
        The search only checks the first and last name of an actor or actress 
        and the title of a movie. Multiple words are allowed but for a result 
        to show up, all words in the search will have to be in the areas searched.
        <br>
        <br>
        <p>
        The results for actors are in ascending order by their date of birth
        and the results for movies are in ascending order by their release date.
        </p>
    </ul>   

    <h3> Search Box: </h3>

    <form action='search.php' method="GET">
        <ul>
            <INPUT TYPE="text" NAME="search" VALUE="" SIZE="50" MAXLENGTH="50" REQUIRED> 
        </ul>
    </form>
    <?php
        $hostname = "localhost";
        $username = "cs143";
        $password = "";
        $db = "cs143";

        $dbconnect=mysqli_connect($hostname,$username,$password,$db);

        if ($dbconnect->connect_error) {
            die("Database connection failed: " . $dbconnect->connect_error);
        }

        $keywords = $_GET['search'];

        if (!empty($_GET)){
            $each_keyword = explode(" ", $keywords);

            //for actor portion
            //write the query
            $query = "SELECT first, last, dob, id FROM Actor WHERE (first LIKE '%$each_keyword[0]%' 
                      OR last LIKE '%$each_keyword[0]%')";
            for ($i = 1; $i < count($each_keyword); $i++){
                $query .= " AND (first LIKE '%$each_keyword[$i]%' OR last LIKE '%$each_keyword[$i]%')";
            }
            $query .= " ORDER BY dob ASC;";

            //search in database now
            $result = $dbconnect->query($query);

            if (mysqli_num_rows($result) > 0){
                echo "<h3> Matching Actors: </h3>";
                echo "<ul>"; 
                echo '<table border="1" cellspacing="2" cellpadding="2"> 
                      <tr> 
                          <td> <b> Name </b> </td> 
                          <td> <b> DOB </b> </td> 
                          <td> <b> Actor Page Link </b> </td>
                      </tr>';
                while($row = $result->fetch_assoc()) {  
                  echo '<tr> 
                            <td>'.$row["first"]." ".$row["last"].'</td> 
                            <td>'.$row["dob"].'</td> 
                            <td style="text-align:center"> <a href="actorinfo.php?actor='.$row["id"].'"> here </a> </td>
                        </tr>';
                }
                echo "</table>";
                echo "</ul>";

                $result->free();
            }
            else {
                echo "<h3> No matching actors were found. </h3>";
            }

            //now for movie portion
            $movie_query = "SELECT title, year, id FROM Movie WHERE (title LIKE '%$each_keyword[0]%')";
            for ($j = 1; $j < count($each_keyword); $j++){
                $movie_query .= " AND (title LIKE '%$each_keyword[$j]%')";
            }
            $movie_query .= " ORDER BY year ASC;";

            $movie_result = $dbconnect->query($movie_query);
            
            if (mysqli_num_rows($movie_result) > 0){
                echo "<h3> Matching Movies: </h3>";
                echo "<ul>"; 
                echo '<table border="1" cellspacing="2" cellpadding="2"> 
                      <tr> 
                          <td> <b> Movie Title </b> </td> 
                          <td> <b> Year </b> </td> 
                          <td> <b> Movie Page Link </b> </td>
                      </tr>';
                while($movie_row = $movie_result->fetch_assoc()) {  
                  echo '<tr> 
                            <td>'.$movie_row["title"].'</td> 
                            <td>'.$movie_row["year"].'</td> 
                            <td style="text-align:center"> <a href="movieinfo.php?movie='.$movie_row["id"].'"> here </a> </td>
                        </tr>';
                }
                echo "</table>";
                echo "</ul>";
                $movie_result->free();
            }
            else {
                echo "<h3> No matching movies were found. </h3>";
            }


            
        }
        $dbconnect->close();
    ?>




</ul>

</table>
</body>
</html>





