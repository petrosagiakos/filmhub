<?php
session_start();
     $server="db";
     $user="admin";
     $pass="admin";
    $db="movies";
   
    $conn=mysqli_connect($server,$user,$pass,$db);
    //session_start();
    if (!isset($_GET['id']) ) {
        die("Invalid movie ID.");
    }
    $movie_id =  $_GET['id']; // Cast to integer for security


    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: login.html"); // Redirect to login page if not logged in
        exit;
    }
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style2.css">
    <title>FilmHub</title>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let video = document.getElementById("movieVideo");

        if (video.textTracks) {
            for (let i = 0; i < video.textTracks.length; i++) {
                video.textTracks[i].mode = "hidden"; // Hide tracks initially
            }
        }

        // Create a subtitle selection dropdown
        let subtitleMenu = document.createElement("select");
        subtitleMenu.id = "subtitleSelector";
        subtitleMenu.innerHTML = "<option value='none'>No Subtitles</option>";

        let tracks = video.getElementsByTagName("track");
        for (let i = 0; i < tracks.length; i++) {
            let label = tracks[i].getAttribute("label") || "Subtitle " + (i + 1);
            subtitleMenu.innerHTML += `<option value="${i}">${label}</option>`;
        }

        subtitleMenu.addEventListener("change", function () {
            for (let i = 0; i < video.textTracks.length; i++) {
                video.textTracks[i].mode = "hidden"; // Hide all
            }
            if (this.value !== "none") {
                video.textTracks[this.value].mode = "showing"; // Show selected subtitle
            }
        });

        document.body.appendChild(subtitleMenu); // Add dropdown to the page
    });
</script>

</head>
<body>
    <?php
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
            <form action="" method="get">
                  
                    </form>
            
   
        </ul>
    </header>';
    }else{
        echo '<header>
        <h1>FilmHub</h1>
        <ul>
            <li><a href="index.php" >Home</a></li>
            <li><a href="logout.php">Logout</a></li>
           
   
        </ul>
    </header>';
    }

    $sql="SELECT * FROM MOVIES WHERE ID='$movie_id' LIMIT 1";//take one record from movies table 
    $result = mysqli_query($conn, $sql);
    $movie = mysqli_fetch_assoc($result);

    if (!$movie) {
        die("Movie not found.");
    }
    // Fetch subtitles for the movie
    $sql_subs = "SELECT * FROM SUBTITLES WHERE MOVIE_ID='$movie_id'";
    $result_subs = mysqli_query($conn, $sql_subs);
    $subtitles = [];
    while ($row = mysqli_fetch_assoc($result_subs)) {
        $subtitles[] = $row; // Store subtitle details
    }

    // Display movie information
    echo "<div class='movie'>
        <h2>" . $movie['NAME'] . "</h2>
        <br>
        <video id='movieVideo' src='./movies/" . $movie['VIDEO'] . "' controls>";

        // Display subtitle tracks if available
        foreach ($subtitles as $subtitle) {
            //echo "<track src='./subtitles/" . $subtitle['SBTL_FILE'] . "' label='" . $subtitle['LANG_CODE'] . "' kind='subtitles' srclang='en'>";
            echo "<track src='./subtitles/" . $subtitle['SBTL_FILE'] . "' label='" . $subtitle['LANG_CODE'] . "' kind='subtitles' srclang='" . $subtitle['LANG_CODE'] . "'>";
        }

        echo "</video>
        <p>" . $movie['DESCR'] . "</p>
        <br>
        <p>" . $movie['CATEGORY'] . "</p>
    </div>";

mysqli_close($conn);
?>

</body>
</html>