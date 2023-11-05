<?php

$host = 'localhost';  
$port = '8889';       
$database = 'art_gallery';  

$username = 'root';  
$password = 'root';  

$dsn = "mysql:host=$host;port=$port;dbname=$database;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock";

try {
    $conn = new PDO($dsn, $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
