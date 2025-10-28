<?php
// conexion 1 de base de datos (form 1 tabla registro)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pre";

// Corrección en la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Fallo la conexión: <br>" . mysqli_connect_error());
}
echo "Conexión exitosa.";
?>
