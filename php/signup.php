<?php
session_start();
 $server="db";
 $user="admin";
 $pass="admin";
$db="movies";

$conn=mysqli_connect($server,$user,$pass,$db);
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD']=="POST"){
$username=$_POST['username'];
$password=$_POST['password'];

$sql="SELECT USERNAME FROM USERS WHERE '$username' IN (SELECT USERNAME FROM USERS)";
$result=mysqli_query($conn,$sql);
$pl=0;
if(mysqli_num_rows($result)>0){
    mysqli_close($conn);
    header("Location: signup.html");
    exit;
}
   


$sql="INSERT INTO USERS(USERNAME,PASSWORD1) VALUES('$username','$password')";
if(mysqli_query($conn,$sql)){
    
    $_SESSION['username'] = $username; 
    mysqli_close($conn);// Store username in session
    header("Location: index.php"); // Redirect to main page
    exit;
}

}

?>