<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmHub</title>
    <link rel="stylesheet" href="./style/form.css">
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
                <ul>
                    <li><a href="index.php" >Home</a></li>
                    <li><a href="am_front.php">Upload Movie</a></li>
                    <li><a href="add_subtitles.php">Add Subtitles</a></li>
                    <li><a href="delete_subtitles.php">Delete Subtitles</a></li>
                    <li><a href="dm_front.php">Delete Movie</a></li>
                    <li><a href="logout.php">Logout</a></li>
                  
           
                </ul>
            </header>';
            }else{
                header("Location: index.php");
              exit;

            }
    
    
    
    ?>
  
    <br><br>
    <div class="form">
    <form action="add_movie.php" method="post" enctype="multipart/form-data">
        <div class="tfile">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required><br>
        </div>
        
        <div class="text">
            <label for="text">Description</label>
            <textarea name="text" id="text" required></textarea><br>
        </div>
        <div class="file">
            <label for="file">Movie</label>
            <input type="file" name="file" id="file" accept=".mp4,.mkv,.mov" required><br>
        </div>
        <div class="img">
            <label for="img">Image</label>
            <input type="file" name="img" id="img" accept=".jpg,.jpeg,.png" required><br>
        </div>
        <div class="img">
            <label for="subs">Upload Subtitles:</label>
            <input type="file" name="subs[]" multiple accept=".srt"><br>
        </div>
        <div class="cat">
            <label for="cat">Category</label>
            <input type="text" name="cat" id="cat" required><br>
        </div>
        <div class="btn">
            <button type="submit">Upload</button>
        </div>
    </form>
    </div>
    <br><br>
    
</body>
</html>