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
$username=$_POST['user'];
$password=$_POST['pass'];


$sql="SELECT USERNAME, PASSWORD1 FROM USERS";
$result=mysqli_query($conn,$sql);
$c=1;
if(mysqli_num_rows($result)>0){
   while($row= mysqli_fetch_assoc($result)){
    if($row['USERNAME']==$username && $row["PASSWORD1"]==$password){
       
        $_SESSION['username'] = $username; // Store username in session
        header("Location: index.php"); // Redirect to main page
        exit;
        $c=0;

    }

   }
}

if($c==1){
  
    header("Location: login.html"); // Redirect to login page
    exit;
}
}
mysqli_close($conn);
?>

