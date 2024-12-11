<?php
$conexion = new mysqli("localhost", "root", "", "nombreBaseDeDatos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameTeam = $_POST['nameTeam'];
    $yearTeam = $_POST['yearTeam'];
    $presTeam = $_POST['presTeam'];
    $stadTeam = $_POST['stadTeam'];
    $budgTeam = $_POST['budgTeam'];
    $imgTeam = $_POST['imgTeam'];

    $sql = "INSERT INTO equipos (nameTeam, yearTeam, presTeam, stadTeam, budgTeam, imgTeam) VALUES ('$nameTeam', '$yearTeam', '$presTeam', '$stadTeam', '$budgTeam', '$imgTeam')";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

$conexion->close();
?>
