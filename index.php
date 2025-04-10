<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/stylemain.css">
    <title>FilmHub</title>
   
</head>
<body>
    
    

        
       <?php
            
            $server="localhost";
            $user="username";
            $pass="password";
            $db="movies";
            session_start();
            $conn=mysqli_connect($server,$user,$pass,$db);
            // Check if the user is logged in
            if (!isset($_SESSION['username'])) {
                header("Location: login.html"); // Redirect to login page if not logged in
                exit;
            }
            $search_term = isset($_GET['s']) ? mysqli_real_escape_string($conn, $_GET['s']) : "";

            if(htmlspecialchars($_SESSION['username'])=="admin"){
                echo '<header>
                <h1>FilmHub</h1>
                <ul id="menu">
                    <li><a href="index.php" >Home </a></li>
                    <li><a href="am_front.php">Upload  Movie</a></li>
                    <li><a href="add_subtitles.php">Add  Subtitles</a></li>
                    <li><a href="delete_subtitles.php">Delete  Subtitles</a></li>
                    <li><a href="dm_front.php">Delete Movie</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <form action="index.php" method="get">
                        <input type="text" placeholder="Search.." name="s">
                        <input type="submit" value="Search">
                    </form>
           
                </ul>
            </header>';
            }else{
                echo '<header>
                <h1>FilmHub</h1>
                <ul id="menu">
                    <li><a href="index.php" >Home</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <form action="index.php" method="get">
                        <input type="text" placeholder="Search.." name="s">
                        <input type="submit" value="Search">
                    </form>
           
                </ul>
            </header>';
            }
            // If logged in, display the main page
            echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "!<br><br>";
            //user id
            $cat="*";
            
            echo "
                <div class='category-filters'>
                    <form action='index.php' method='get'>
                    <label for='category'>Choose a category:</label>
                <select name='category' id='category'>
                <option value=''>All</option>";
                    // Fetch distinct categories from the database
                    $cat_query = "SELECT DISTINCT CATEGORY FROM movies";
                    $cat_result = mysqli_query($conn, $cat_query);
                    while ($cat_row = mysqli_fetch_assoc($cat_result)) {
                        $selected = (isset($_GET['category']) && $_GET['category'] == $cat_row['CATEGORY']) ? 'selected' : '';
                        echo "<option value='" . $cat_row['CATEGORY'] . "' $selected>" . $cat_row['CATEGORY'] . "</option>";
                        if($selected=="selected"){
                            $cat=$cat_row['CATEGORY'];

                        }
                    }

            echo "      </select>
                <input type='submit' value='Filter'>

                 </form>
                </div>
            ";

            echo "<div class='movie-list'>";
            $category=isset($_GET['category'])? mysqli_real_escape_string($conn, $_GET['category']) : "";
            $sql = "SELECT * FROM movies WHERE 1";
            if (!empty($search_term)) {
                $sql .= " AND NAME LIKE '%$search_term%'";
                
            }
            if(!empty($category)){
                $sql.=" AND CATEGORY= '$category' ";
            }
            $sql.=" Order by ID DESC";
            $result=mysqli_query($conn,$sql);
       
            if(mysqli_num_rows($result)>0){
                while($row= mysqli_fetch_assoc($result)){
                    echo '<div class="movie-item">
                            <a href="movie.php?id=' . $row['ID'] . '">
                                <img src="images/' . $row['IMAGES'] . '" alt="' . $row['NAME'] . '" width="150">
                                <p>' . $row['NAME'] . '</p>
                            </a>
                        </div>';
                    
                }
            }
            echo "</div>"
              
            ?>
 
       
        <div>
    
    
      
    </div>
</body>
</html>
