<!DOCTYPE html>
<html>
<body>

<H1 align="center"> Actor Information Page </H1>


<nav>
  <ul>
  <h3> Navigation </h3>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="search.php">Search Actor/Movie</a></li>
        <li><strong>Actor Information Page</strong></li>
        <li><a href="movieinfo.php?movie=2632">Movie Information Page</a></li>
        <li><a href="reviews.php?review=2632">Add Movie Review</a></li>
    </ul>
  </ul>
</nav>



<ul>
    <h3> Description: </h3>
    <ul>
        <p> On this page you can find pertinent information of an actor 
        like name, sex, date of birth, date of death, movies they were in,
        and their roles in those movies. By default, this page will give 
        the information of Julia Roberts. To find other actors information,
        go to the search page and click the "Actor Page Link."
        </p>
    </ul>


    <form action='actorinfo.php' method="GET"><INPUT TYPE="hidden" NAME="actor" VALUE="">
    <?php
        $hostname = "localhost";
        $username = "cs143";
        $password = "";
        $db = "cs143";

        $dbconnect=mysqli_connect($hostname,$username,$password,$db);

        if ($dbconnect->connect_error) {
            die("Database connection failed: " . $dbconnect->connect_error);
        }

        $actorid = $_GET['actor'];

        if (!empty($_GET)){
            $actor_query = "SELECT * FROM Actor WHERE id = $actorid;";

            $actor_result = $dbconnect->query($actor_query);

            if (mysqli_num_rows($actor_result) > 0){
                echo "<h3> Actor Information: </h3>";
                echo "<ul>"; 
                echo '<table border="1" cellspacing="2" cellpadding="2"> 
                      <tr> 
                          <td> <b> Name </b> </td> 
                          <td> <b> Sex </b> </td> 
                          <td> <b> Date of Birth </b> </td>
                          <td> <b> Date of Death </b> </td>
                      </tr>';
                while($row = $actor_result->fetch_assoc()) {  
                  if ($row["dod"] === NULL){
                      $dod = "Still Alive";
                  }
                  else {
                    $dod = $row["dod"];
                  }
                  echo '<tr> 
                            <td>'.$row["first"]." ".$row["last"].'</td> 
                            <td>'.$row["sex"].'</td> 
                            <td>'.$row["dob"].'</td> 
                            <td>'.$dod.'</td> 
                        </tr>';
                }
                echo "</table>";
                echo "</ul>";
                $actor_result->free();
            }

            $movieroles_query = "SELECT role, title, mid 
                                 FROM MovieActor MA, Movie M
                                 WHERE MA.aid = $actorid AND MA.mid = M.id;";


            $movieroles_result = $dbconnect->query($movieroles_query);

            if (mysqli_num_rows($movieroles_result) > 0){
                echo "<h3> Actor's Movies and Roles: </h3>";
                echo "<ul>"; 
                echo '<table border="1" cellspacing="2" cellpadding="2"> 
                      <tr> 
                          <td> <b> Role </b> </td> 
                          <td> <b> Movie Title <b/> </td> 
                          <td> <b> Movie Page Link </b> </td> 
                      </tr>';
                while($row = $movieroles_result->fetch_assoc()) { 
                    echo '<tr> 
                        <td>'.$row["role"].'</td> 
                        <td>'.$row["title"].'</td> 
                        <td style="text-align:center"> <a href="movieinfo.php?movie='.$row["mid"].'"> here </a> </td>
                    </tr>';
                }
                echo "</table>";
                echo "</ul>";
                $movieroles_result->free();
            }
            else {
                echo "<h3> No roles or movies are in the database for this actor </h3>";
            }
        }
        $dbconnect->close();
      ?>
</ul>

</body>
</html>

