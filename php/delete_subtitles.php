<?php
session_start();
     $server="db";
     $user="admin";
     $pass="admin";
    $db = "movies";
    
    
    $conn = mysqli_connect($server, $user, $pass, $db);
    
    // Check if the user is logged in
    if (!isset($_SESSION['username']) || htmlspecialchars($_SESSION['username']) != "admin") {
        header("Location: index.php");
        exit;
    }
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Subtitles - FilmHub</title>
    <link rel="stylesheet" href="./style/form.css">
</head>
<body>
    <?php
    echo '<header>
        <h1>FilmHub</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
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
        <form action="delete_subtitles.php" method="post">
            <div class='category-filters'>
                <label for='subid'>Select a Subtitle to Delete</label>
                <select name='subid' id='subid' required>
                    <option value="">-- Choose a Subtitle --</option>
                    <?php
                    // Fetch movies that have subtitles
                    $sub_query = "SELECT ID,SBTL_FILE
                                  FROM SUBTITLES
                                  ";
                    $sub_result = mysqli_query($conn, $sub_query);
                    
                    while ($sub_row = mysqli_fetch_assoc($sub_result)) {
                        echo "<option value='" . $sub_row['ID'] . "'>" . htmlspecialchars($sub_row['SBTL_FILE']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="btn">
                <button type="submit">Delete</button>
            </div>
        </form>
    </div>

    <br><br>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subid'])) {
        $id = (int) $_POST['subid'];
        
        
        $sql_subs = "SELECT * FROM SUBTITLES WHERE ID='$id'";
        $result = mysqli_query($conn, $sql_subs);
        $subs = mysqli_fetch_assoc($result);
        unlink("./subtitles/".$subs['SBTL_FILE']);
        $sql_subs = "DELETE  FROM SUBTITLES WHERE ID='$id'";
        mysqli_query($conn, $sql_subs);

       
    }

    mysqli_close($conn);
    ?>

</body>
</html>
