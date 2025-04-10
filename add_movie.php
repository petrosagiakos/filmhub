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
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit;
}
if(htmlspecialchars($_SESSION['username'])!="admin"){
    header("Location: index.php"); // Redirect to login page if not admin
    exit;
}
if($_SERVER['REQUEST_METHOD']=="POST"){

$title=$_POST['title'];
$text=$_POST['text'];
$cat=$_POST['cat'];
if (isset($_FILES["file"])&&isset($_FILES["img"])&&isset($_FILES["subs"])) {
    // Proceed with file upload logic
    $target_dir="movies/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    $img_dir="images/";
    $img_file = $img_dir . basename($_FILES["img"]["name"]);

    $sub_dir = "subtitles/";
    $allowed_extensions = ['vtt', 'srt', 'sub'];
    $sub_files = [];

    $uploadOk = 1;

    if (file_exists($target_file)||file_exists($img_file)) {
        echo "Sorry, file already exists.";
        echo "<br> <a href='index.php'>Go Back</a>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file) && 
            move_uploaded_file($_FILES["img"]["tmp_name"], $img_file)) {
            
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";

            $f = basename($_FILES["file"]["name"]);
            $img = basename($_FILES["img"]["name"]);

            // Insert movie into database
            $sql = "INSERT INTO movies (name, descr, video, images, category) 
                    VALUES ('$title', '$text', '$f', '$img', '$cat')";
            
            if (mysqli_query($conn, $sql)) {
                $movie_id = mysqli_insert_id($conn); // Get the newly inserted movie ID

                // Upload subtitles
                foreach ($_FILES["subs"]["tmp_name"] as $key => $tmp_name) {
                    $file_name = $_FILES["subs"]["name"][$key];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                    if (in_array($file_ext, $allowed_extensions)) {
                        $sub_target = $sub_dir . basename($file_name);
                        
                        if (move_uploaded_file($tmp_name, $sub_target)) {
                            // Extract language from filename (e.g., "subtitles_en.vtt" → "en")
                            $filename_without_ext = pathinfo($file_name, PATHINFO_FILENAME);
                            $parts = explode("-", $filename_without_ext);
                            $lang_code = end($parts);
                            
                            // Insert subtitle record into the subtitles table
                            $sql_sub = "INSERT INTO subtitles (SBTL_FILE, MOVIE_ID, LANG_CODE) 
                                        VALUES ('$file_name', '$movie_id','$lang_code')";
                            mysqli_query($conn, $sql_sub);
                        }
                    } else {
                        echo "Invalid subtitle format: " . htmlspecialchars($file_name);
                    }
                }

                echo "Movie and subtitles uploaded successfully!";
                echo "<br> <a href='index.php'>Go Back</a>";
            } else {
                unlink($target_file);
                unlink($img_file);
                echo "Error inserting movie record.";
                echo "<br> <a href='index.php'>Go Back</a>";
            }
        } else {
            echo "Error uploading files.";
            echo "<br> <a href='index.php'>Go Back</a>";
        }
    }
} else {
    echo "No file was uploaded.";
    echo "<br> <a href='index.php'>Go Back</a>";
}
}

header("Location: am_front.php");
exit;
mysqli_close($conn);
?>