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
$username=$_POST['user'];
$password=$_POST['pass'];


$sql="SELECT username, password1 FROM USERS";
$result=mysqli_query($conn,$sql);
$c=1;
if(mysqli_num_rows($result)>0){
   while($row= mysqli_fetch_assoc($result)){
    if($row['username']==$username && $row["password1"]==$password){
        echo "succesful connection"." <br>";
        $_SESSION['username'] = $username; // Store username in session
        header("Location: index.php"); // Redirect to main page
        exit;
        $c=0;

    }

   }
}

if($c==1){
    echo "invalid connection";
    header("Location: login.html"); // Redirect to login page
    exit;
}
}
mysqli_close($conn);
?>

