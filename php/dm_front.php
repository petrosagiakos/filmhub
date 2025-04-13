<?php
session_start();
 $server="db";
 $user="admin";
 $pass="admin";
            $db="movies";
            
            $conn=mysqli_connect($server,$user,$pass,$db);
            // Check if the user is logged in
            if (!isset($_SESSION['username']) || htmlspecialchars($_SESSION['username']) != "admin") {
                header("Location: login.html"); // Redirect to login page if not logged in
                exit;
            }
            

        
                ?>
                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/form.css">
    <title>FilmHub</title>
</head>
<body>
                <?php
                $search_term = isset($_GET['s']) ? mysqli_real_escape_string($conn, $_GET['s']) : "";
                echo '<header>
                <h1>FilmHub</h1>
                <ul>
                    <li><a href="index.php" >Home</a></li>
                    <li><a href="am_front.php">Upload Movie</a></li>
                    <li><a href="add_subtitles.php">Add Subtitles</a></li>
                    <li><a href="delete_subtitles.php">Delete Subtitles</a></li>
                    <li><a href="dm_front.php">Delete Movie</a></li>
                    <li><a href="logout.php">Logout</a></li>
                   
           
                </ul>
            </header>';
            
    
    
    
    ?>
    <br><br>
    <div class="form">
        <form action="delete_movie.php" method="post" enctype="multipart/form-data">
        <div class='category-filters'>
        <label for='movid'>Choose a Movie to Delete:</label>
                <select name='movid' id='movid'>
               
        <?php
        
                    // Fetch distinct categories from the database
                    $cat_query = "SELECT ID,NAME FROM MOVIES";
                    
                    $cat_result = mysqli_query($conn, $cat_query);
                    while ($cat_row = mysqli_fetch_assoc($cat_result)) {
                       
                        echo "<option value='" . $cat_row['ID'] . "' > " . $cat_row['NAME'] . "</option>";
                        
                    }

            ?>
            </select>
                </div>
        <div class="btn">
            <button type="submit">Delete</button>
        </div>
        </form>
    </div>
</body>
</html>