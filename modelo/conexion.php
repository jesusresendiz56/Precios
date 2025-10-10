<?php
$host = 'localhost';     
$port = 3306;           
$user = 'root';
$pass = '';              
$db   = 'precios';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die('Error al conectar: ' . mysqli_connect_error());
}
echo 'Conexión correcta (mysqli)';
?>
