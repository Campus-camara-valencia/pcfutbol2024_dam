<?php
header('Content-Type: application/json');
include 'conexion.php';

session_start();

$idEquipo = $_SESSION['idEquipo'] ?? null;
if (!$idEquipo) {
    echo json_encode(['success' => false, 'error' => 'Debes crear un equipo antes de fichar jugadores.']);
    exit;
}

$fichajes = json_decode($_POST['fichajes'], true);

$totalJugadores = count($fichajes);
if ($totalJugadores < 11 || $totalJugadores > 15) {
    echo json_encode(['success' => false, 'error' => 'El equipo debe tener entre 11 y 15 jugadores.']);
    exit;
}

$noComunitarios = 0;
$presupuestoTotal = 0;

foreach ($fichajes as $jugador) {
    $presupuestoTotal += $jugador['pricePlayer'];
    if ($jugador['natPlayer'] === 'No comunitaria') {
        $noComunitarios++;
    }
}

if ($presupuestoTotal > 100) {
    echo json_encode(['success' => false, 'error' => 'Presupuesto excedido. No puedes gastarte más de 100.']);
    exit;
}

if ($noComunitarios > 4) {
    echo json_encode(['success' => false, 'error' => 'No puedes tener más de 4 jugadores no comunitarios.']);
    exit;
}

foreach ($fichajes as $jugador) {
    $sql = "INSERT INTO Player (namePlayer, agePlayer, natPlayer, posPlayer, levelPlayer, footPlayer, partidos_jugados, goles) 
            VALUES ($idEquipo, '{$jugador['namePlayer']}', {$jugador['agePlayer']}, '{$jugador['natPlayer']}', '{$jugador['posPlayer']}', {$jugador['levelPlayer']}, '{$jugador['footPlayer']}', 0, 0)";

    if ($conn->query($sql) !== TRUE) {
        echo json_encode(['success' => false, 'error' => 'Error al insertar jugador: ' . $conn->error]);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => 'Fichajes realizados con éxito.']);
?>
