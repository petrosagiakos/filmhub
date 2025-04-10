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
    <form action="add_subtitles.php" method="post" enctype="multipart/form-data">
       
        <div class='category-filters'>
        <label for='movid'>Choose a category:</label>
                <select name='movid' id='movid'>
               
        <?php
        
                    // Fetch distinct categories from the database
                    $cat_query = "SELECT ID,name FROM movies";
                    
                    $cat_result = mysqli_query($conn, $cat_query);
                    while ($cat_row = mysqli_fetch_assoc($cat_result)) {
                       
                        echo "<option value='" . $cat_row['ID'] . "' > " . $cat_row['name'] . "</option>";
                        
                    }

            ?>
            </select>
                </div>
        <div class="img">
            <label for="subs">Upload Subtitles:</label>
            <input type="file" name="subs[]" multiple accept=".srt,.vtt"><br>
        </div>
      
        <div class="btn">
            <button type="submit">Upload</button>
        </div>
    </form>
    </div>
    <br><br>
    <?php
        
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["subs"]) && isset($_POST['movid'])) {
                $id = (int) $_POST['movid']; 
           
        
            $sub_dir = "subtitles/";
            $allowed_extensions = ['vtt', 'srt', 'sub'];
            $sub_files = [];
            
     
        
           
        
            
                    
        
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
                                                VALUES ('$file_name', '$id','$lang_code')";
                                    mysqli_query($conn, $sql_sub);
                                }
                            } else {
                                echo "Invalid subtitle format: " . htmlspecialchars($file_name);
                            }
                        }
        
                      
                    }
         
        
    ?>
    
</body>
</html>