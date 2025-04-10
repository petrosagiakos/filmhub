<?php
$server = "localhost";
$user = "username";
$pass = "password";
$db = "movies";

// Establish connection
$conn = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL for creating 'movies' table
$sql = "CREATE TABLE movies (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(255),
    DESCR TEXT,
    VIDEO VARCHAR(255),
    IMAGE VARCHAR(255),
    CATEGORY VARCHAR(255)
)";

// SQL for creating 'users' table
$sql2 = "CREATE TABLE users (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    USERNAME VARCHAR(255),
    PASSWORD1 VARCHAR(255),
    VIDEO VARCHAR(255),
    IMAGE VARCHAR(255),
    CATEGORY VARCHAR(255)
)";

// SQL for creating 'subtitles' table
$sql3 = "CREATE TABLE subtitles (
    ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    SBTL_FILE VARCHAR(255),
    MOVIE_ID INT(11),
    LANG_CODE VARCHAR(11),
    FOREIGN KEY (MOVIE_ID) REFERENCES movies(ID)
)";

// Execute queries
if (mysqli_query($conn, $sql)) {
    echo "Table 'movies' created successfully.<br>";
} else {
    echo "Error creating table 'movies': " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql2)) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table 'users': " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql3)) {
    echo "Table 'subtitles' created successfully.<br>";
} else {
    echo "Error creating table 'subtitles': " . mysqli_error($conn) . "<br>";
}

// Close connection
mysqli_close($conn);
?>
