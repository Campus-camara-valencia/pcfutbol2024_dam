<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbs13591604";

// Crear la conexión 
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener datos del formulario
$nameUser = $_POST['nameUser'] ?? '';
$passUser = md5($_POST['passUser'] ?? ''); //IMPORTANTE SE GUARDA ENCRIPTADO
$emailUser = $_POST['emailUser'] ?? '';
date_default_timezone_set('UTC');
$dateUser = $_POST['dateUser'] ?? date('Y-m-d');

// Validar datos
if (empty($nameUser) || empty($passUser) || empty($emailUser)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
    $conn->close();
    exit;
}

// Preparar la consulta SQL
$sql = "INSERT INTO Usr (nameUser, passUser, emailUser, dateUser) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Error al preparar la consulta: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("ssss", $nameUser, $passUser, $emailUser, $dateUser);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Usuario registrado con éxito"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al registrar el usuario: " . $stmt->error]);
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
