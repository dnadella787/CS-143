<!DOCTYPE html>
<html>
<body>

<H1 align="center"> Movie Information Page </H1>


<nav>
  <ul>
    <h3> Navigation </h3>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="search.php">Search Actor/Movie</a></li>
        <li><a href="actorinfo.php?actor=52794">Actor Information Page</a></li>
        <li><strong>Movie Information Page</strong></li>
        <li><a href="reviews.php?review=2632">Add Movie Review</a></li>
    </ul>
  </ul>
</nav>



<ul>
    <h3> Description: </h3>
    <ul>
        <p> You will find pertinent information for a movie such as
        the title, producer, rating, director, genre, 
        actors and actresses that were in the movie, and user reviews.
        You may also add a review from this page by clicking the link under "User Reviews"
        if reviews already exist or under "Average Score" if no reviews exist yet.
        By default, this page will show the movie information for "The Matrix."
        <p>
    </ul>

    <form action='movieinfo.php' method="GET"><INPUT TYPE="hidden" NAME="movie" VALUE=""> </form>
    <?php
        $hostname = "localhost";
        $username = "cs143";
        $password = "";
        $db = "cs143";

        $dbconnect=mysqli_connect($hostname,$username,$password,$db);

        if ($dbconnect->connect_error) {
            die("Database connection failed: " . $dbconnect->connect_error);
        }

        $movieid = $_GET['movie'];

        if (!empty($_GET)){
            $movie_query = "SELECT title, year, rating, company
                            FROM Movie 
                            WHERE id = $movieid;";
            $movie_result = $dbconnect->query($movie_query);

            if (mysqli_num_rows($movie_result) > 0){
                echo "<h3> Movie Information: </h3>";
                echo "<ul>";
                while($row = $movie_result->fetch_assoc()) {  
                    echo "<b> Title: </b>".$row["title"]." "."(".$row["year"].")<br>";
                    echo "<b> Producer: </b>".$row["company"]."<br>";
                    echo "<b> MPAA Rating: </b>".$row["rating"]."<br>";
                }
                $movie_result->free();
            
                $director_query = "SELECT first, last, dob
                                   FROM MovieDirector MD, Director D 
                                   WHERE MD.mid = $movieid AND MD.did = D.id;"; 
                $director_result = $dbconnect->query($director_query);
                echo "<b> Director(s):</b>";
                if (mysqli_num_rows($director_result) > 0){
                    $directors ="";
                    while($row = $director_result->fetch_assoc()) {  
                        $directors.= " ".$row["first"]." ".$row["last"]." (".$row["dob"]."),";
                    }
                    $director_result->free();
                    echo substr($directors, 0, -1);
                }
                else {
                    echo " no directors for this movie in the database";
                }

                $genre_query = "SELECT genre 
                                FROM MovieGenre 
                                WHERE mid = $movieid;";
                $genre_result = $dbconnect->query($genre_query);
                echo "<br><b> Genre:</b>";
                if (mysqli_num_rows($genre_result) > 0){
                    $genre="";
                    while($row = $genre_result->fetch_assoc()){
                        $genre.=" ".$row["genre"].",";
                    }
                    echo substr($genre, 0, -1);
                    $genre_result->free();
                }
                else {
                    echo " no genres for this movie in the database";
                }
                echo "</ul>";
            }

            $actors_query = "SELECT role, first, last, aid
                             FROM Actor A, MovieActor MA
                             WHERE MA.mid = $movieid AND A.id = MA.aid;";
            $actors_result = $dbconnect->query($actors_query);
            if (mysqli_num_rows($actors_result) > 0){
                echo "<h3> Actor and Roles: </h3>";
                echo "<ul>"; 
                echo '<table border="1" cellspacing="2" cellpadding="2"> 
                      <tr> 
                          <td> <b> Actor Name </b> </td> 
                          <td> <b> Role in Movie </b> </td> 
                          <td> <b> Actor Page Link </b> </td> 
                      </tr>';

                while ($row = $actors_result->fetch_assoc()){
                    echo '<tr> 
                            <td>'.$row["first"].' '.$row["last"].'</td> 
                            <td>'.$row["role"].'</td> 
                            <td style="text-align:center"> <a href="actorinfo.php?actor='.$row["aid"].'"> here </a> </td>
                        </tr>';
                }
                echo "</table>";
                echo "</ul>";
                $actors_result->free();
            }

            echo "<h3> Average Score: </h3>";
            echo "<ul>";
            $avg_query = "SELECT AVG(rating) avg, COUNT(time) num FROM Review WHERE mid = ".$movieid.";";
            $avg_result = $dbconnect->query($avg_query);
            $row = $avg_result->fetch_assoc();
            if (($row["avg"] === NULL) and ($row["num"] == 0)){
                echo "Nobody has written a review for this movie yet. You could be the first by clicking ";
                echo '<a href="reviews.php?review='.$movieid.'">here</a>!';
            }
            else {
                echo "Average score for this movie is <b>".$row["avg"]."</b> out of <b>5</b> over <b>".$row["num"]."</b> reviews.";
            }
            $avg_result->free();
            echo "</ul>";


            $review_query = "SELECT * FROM Review WHERE mid = $movieid;";
            $review_result = $dbconnect->query($review_query);
            if (mysqli_num_rows($review_result) > 0){
                echo "<h3> User Reviews: </h3>";
                echo "<ul>";
                echo 'You can add your own review by clicking <a href="reviews.php?review='.$movieid.'">here</a>!<br><br>';
                while ($row = $review_result->fetch_assoc()){
                    echo "<b>".$row["name"]."</b> rated this movie a <b>".$row["rating"]."</b> out of <b>5</b> on <b>".$row["time"]."</b> 
                    and left a comment:<br>";
                    echo "<ul><i>".$row["comment"]."</i></ul><br>";
                }
                $review_result->free();
                echo "</ul>";
            }
        }
        $dbconnect->close();
    ?>
      
</ul>

</body>
</html>


