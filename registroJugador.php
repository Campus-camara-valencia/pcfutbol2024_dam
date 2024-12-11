<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "dbs13591604";

$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos del jugador (normalmente vienen de un formulario)
$idTeam = $_POST['idTeam'];
$namePlayer = $_POST['namePlayer'];
$agePlayer = $_POST['agePlayer'];
$natPlayer = $_POST['natPlayer'];
$posPlayer = $_POST['posPlayer'];
$levelPlayer = $_POST['levelPlayer'];

// Validar datos básicos
if ($agePlayer < 18 || $agePlayer > 37) {
    die("La edad del jugador debe estar entre 18 y 37 años.");
}

if ($levelPlayer < 1 || $levelPlayer > 10) {
    die("El nivel del jugador debe estar entre 1 y 10.");
}

// Insertar datos del jugador
$sql = "INSERT INTO Player (idTeam, namePlayer, agePlayer, natPlayer, posPlayer, levelPlayer) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $idTeam, $namePlayer, $agePlayer, $natPlayer, $posPlayer, $levelPlayer);

if ($stmt->execute()) {
    echo "Jugador registrado correctamente.";
} else {
    echo "Error al registrar el jugador: " . $conn->error;
}

// Cerrar conexión
$stmt->close();
$conn->close();
