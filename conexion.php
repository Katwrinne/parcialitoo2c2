<?php
$conexion = new mysqli("localhost", "root", "", "farmacia_buena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>