<?php

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($username == "admin" && $password == "admin"){
  header("Location: admin.php"); /* Redirect browser */
}
elseif($username == "user" && $password == "user"){
header("Location: user.php"); /* Redirect browser */
}

else{
  header("Location: index.php"); /* Redirect browser */
}
?>
