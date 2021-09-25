<!DOCTYPE html>
<html>
<body>

<H1 align="center"> Add Movie Review </H1>


<nav>
  <ul>
  <h3> Navigation </h3>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="search.php">Search Actor/Movie</a></li>
      <li><a href="actorinfo.php?actor=52794">Actor Information Page</a></li>
      <li><a href="movieinfo.php?movie=2632">Movie Information Page</a></li>
      <li><strong>Add Movie Review</strong></li>
    </ul>
  </ul>
</nav>




<ul>
    <h3> Description: </h3>
    <ul>
        <p> You can add a rating and a review for a movie here.
        By default this page will take you to add a review for "Matrix, The."
        </p>
    </ul>



<form action="reviews.php" method="GET">
  <INPUT TYPE="hidden" NAME="review" VALUE="<?php if(isset($_GET['review'])){echo $_GET['review'];} ?>">
  <?php
        $hostname = "localhost";
        $username = "cs143";
        $password = "";
        $db = "cs143";

        $dbconnect=mysqli_connect($hostname,$username,$password,$db);

        if ($dbconnect->connect_error) {
            die("Database connection failed: " . $dbconnect->connect_error);
        }

        $movieid = $_GET['review'];
        if (!empty($movieid)){
            $movie_query = "SELECT title, year FROM Movie WHERE id = $movieid;";
            $movie_result = $dbconnect->query($movie_query);

            if (mysqli_num_rows($movie_result) > 0){
                echo "<h3> Movie Title: </h3>";
                echo "<ul>";
                while($row = $movie_result->fetch_assoc()) {  
                  echo $row["title"]." (".$row["year"].")";
                }
                $movie_result->free();
                echo "</ul>";
            }
        }
  ?>
  <h3> Name: </h3>
  <ul style="padding-left: 40px">
      <INPUT TYPE="text" VALUE="Dingleberry Bob" NAME="reviewer" MAXLENGTH="30" SIZE="30" REQUIRED>
  </ul>

  <h3> Comment: </h3>
  <ul style="padding-left: 40px">
      <textarea rows="6" cols="70" name="comment" REQUIRED></textarea>
  </ul>

  <h3> Rating (out of 5): </h3>
  <ul style="padding-left: 40px">
    <INPUT type="radio" name="rating" value=1> 1
    <INPUT type="radio" name="rating" value=2> 2
    <INPUT type="radio" name="rating" value=3 checked> 3
    <INPUT type="radio" name="rating" value=4> 4 
    <INPUT type="radio" name="rating" value=5> 5
    <br>
    <br>
    <INPUT TYPE="submit" VALUE="done">
  </ul>
</form>

<?php
  $name = $_GET["reviewer"];
  $rating = $_GET["rating"];
  $comment = $_GET["comment"];
  $timestamp = date('Y-m-d H:i:s');

  if (!empty($comment)){
      $review_query = "INSERT INTO Review VALUES ('$name', '$timestamp', $movieid, $rating, '$comment');";
      if ($dbconnect->query($review_query) == TRUE){
          echo "<ul><ul><br>";
          echo "<b> Review Added to our Database! </b><br>";
          echo 'click <a href="movieinfo.php?movie='.$movieid.'">here</a> to go back to the movie information page.';
          echo "</ul></ul>";
      }
      else {
          echo "Error: " . $review_query . "<br>" . $dbconnect->error;
      }
  }
  $dbconnect->close();
?>



</ul>
</ul>

</body>
</html>