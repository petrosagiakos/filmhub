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

if($_SERVER['REQUEST_METHOD']=="POST"){
$username=$_POST['username'];
$password=$_POST['password'];

$sql="SELECT username FROM USERS";
$result=mysqli_query($conn,$sql);
$pl=0;
if(mysqli_num_rows($result)>0){
   while($row= mysqli_fetch_assoc($result)){
    if($row['username']==$username){
        echo "Username ".$username." already exists";

    }
else{
    $pl=$pl+1;
}
   }
}
if($pl==mysqli_num_rows($result)){
$sql="INSERT INTO USERS(username,password1) VALUES('$username','$password')";
if(mysqli_query($conn,$sql)){
    echo "you have been signed up";
    $_SESSION['username'] = $username; // Store username in session
    header("Location: index.php"); // Redirect to main page
    exit;
}
else{
    echo "error with signing up";
}}
}
mysqli_close($conn);
?>