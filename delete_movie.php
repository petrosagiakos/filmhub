<?php
$server="localhost";
$user="username";
$pass="password";
$db="movies";
session_start();
$conn=mysqli_connect($server,$user,$pass,$db);
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

if (!isset($_SESSION['username']) || htmlspecialchars($_SESSION['username']) != "admin") {
    header("Location: login.html");
    exit;
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id=$_POST['movid'];

    // Fetch movie details
    $sql="SELECT * FROM MOVIES WHERE ID='$id'";
    $result = mysqli_query($conn, $sql);
    $movie = mysqli_fetch_assoc($result);

    if (!$movie) {
        die("Movie not found.");
    }

    $file_vid="movies/".$movie["VIDEO"];
    $file_img="images/".$movie["IMAGES"];

    // Delete subtitle files
    $sql_sub="SELECT * FROM subtitles WHERE MOVIE_ID='$id'";
    $result_sub=mysqli_query($conn, $sql_sub);
    while($row = mysqli_fetch_assoc($result_sub)){
        $sub_file = "./subtitles/" . $row['SBTL_FILE'];
        if (file_exists($sub_file)) {
            unlink($sub_file) ? print "Subtitle " . $row['SBTL_FILE'] . " deleted.<br>" : print "Error deleting subtitle " . $row['SBTL_FILE'] . ".<br>";
        }
    }

    // Delete video and image files
    if (file_exists($file_vid)) {
        unlink($file_vid) ? print "Video deleted.<br>" : print "Error deleting video.<br>";
    }
    if (file_exists($file_img)) {
        unlink($file_img) ? print "Image deleted.<br>" : print "Error deleting image.<br>";
    }

    

    // Delete subtitles record
    $sql_sub2="DELETE FROM subtitles WHERE MOVIE_ID='$id'";
    if (mysqli_query($conn, $sql_sub2)) {
        echo "Subtitles deleted successfully.<br>";
    } else {
        echo "Error deleting subtitles: " . mysqli_error($conn) . "<br>";
    }

// Delete movie record
$sql="DELETE FROM MOVIES WHERE ID='$id'";
if (mysqli_query($conn, $sql)) {
    echo "Movie record deleted successfully.<br>";
} else {
    echo "Error deleting movie: " . mysqli_error($conn) . "<br>";
}
}
mysqli_close($conn);
header("Location: dm_front.php");
exit;
?>