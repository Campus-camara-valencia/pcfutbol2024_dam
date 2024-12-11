<?php
header('Content-Type: application/json');
include 'conexion.php';

session_start();

$idEquipo = $_SESSION['idEquipo'] ?? null;

if (!$idEquipo) {
    echo json_encode(['success' => false, 'error' => 'Debes crear un equipo antes de ver la plantilla.']);
    exit;
}

$sqlEquipo = "SELECT nameTeam, presTeam FROM Team WHERE idTeam = $idTeam";
$resultEquipo = $conn->query($sqlEquipo);

if ($resultEquipo->num_rows > 0) {
    $equipo = $resultEquipo->fetch_assoc();
} else {
    echo json_encode(['success' => false, 'error' => 'Equipo no encontrado.']);
    exit;
}

$sqlJugadores = "SELECT idPlayer, namePlayer, agePlayer, natPlayer, posPlayer, levelPlayer  FROM Player WHERE idTeam = $idTeam";
$resultJugadores = $conn->query($sqlJugadores);

$jugadores = [];
while ($row = $resultJugadores->fetch_assoc()) {
    $jugadores[] = $row;
}

echo json_encode(['success' => true, 'equipo' => $equipo, 'jugadores' => $jugadores]);
?>
