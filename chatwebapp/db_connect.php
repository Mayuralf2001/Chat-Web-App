<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "chatwebapp";

//Crerating database connection

$conn = mysqli_connect($servername, $username, $password, $database);

//Check connection
if(!$conn){
    die("Failed to connect: " . mysqli_connect_error());
}
?>