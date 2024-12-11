<?php
header('Content-Type: application/json');
include 'conexion.php';

$namePlayer = $_POST['namePlayer'];
$agePlayer = $_POST['agePlayer'];
$nacionalidad = $_POST['natPlayer'];
$posicion = $_POST['posPlayer'];
$pie = $_POST['footPlayer']; 
$statsPlayer = $_POST['statsPlayer']; 

$nivel = calcularNivel($edad);
$precio = calcularPrecio($edad, $nivel);

$sql = "INSERT INTO jugadores (namePlayer, agePlayer, natPlayer, posPlayer, nivel, precio, footPlayer, statsPlayer)
        VALUES ('$idJugador', '$namePlayer', $agePlayer, '$natPlayer', '$posPlayer', $nivel, $precio, '$footPlayer', '$statsPlayer')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();

function calcularNivel($edad) {
    if ($edad >= 18 && $edad <= 24) {
        return rand(1, 6);
    } elseif ($edad > 24 && $edad <= 33) {
        return rand(1, 10);
    } elseif ($edad > 33) {
        return rand(1, 6); 
    }
}

function calcularPrecio($edad, $nivel) {
    if ($edad >= 18 && $edad <= 24) {
        return 6 + ($nivel * 1.8); 
    } elseif ($edad > 24 && $edad <= 33) {
        return 4 + ($nivel * 1.6); 
    } elseif ($edad > 33) {
        return 2 + ($nivel * 1.2); 
    }
}
?>
