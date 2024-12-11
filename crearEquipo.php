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
//Necesitamos tambien la fecha de presidente, la cual podemos pedir aqui o guardar en el otro php------------
$nameTeam = $_POST['nameTeam'] ?? '';
$yearTeam = $_POST['yearTeam'] ?? '';
$presTeam = $_POST['presTeam'] ?? '';
$stadTeam = $_POST['stadTeam'] ?? '';
$imgTeam = $_POST['imgTeam'] ?? '';
$budgTeam = $_POST['budgTeam'] ?? '';

/*  idTeam INT AUTO_INCREMENT PRIMARY KEY,
    nameTeam VARCHAR(255) NOT NULL,
    yearTeam INT NOT NULL,
    presTeam VARCHAR(255),
    stadTeam VARCHAR(255),
    imgTeam VARCHAR(255),
    budgTeam DECIMAL(15, 2) NOT NULL*/

// Validar datos
if (empty($nameTeam) || empty($yearTeam) || empty($presTeam) || empty($stadTeam) || empty($imgTeam) || empty($budgTeam)) {
    echo json_encode(["status" => "error", "message" => "Algo no ha salido bien"]);
    $conn->close();
    exit;
}


// Preparar la consulta SQL
$sql = "INSERT INTO Team (nameTeam, yearTeam, presTeam, stadTeam, imgTeam, budgTeam) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Error al preparar la consulta: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("sissi", $nameUser, $passUser, $emailUser, $dateUser);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Usuario registrado con éxito"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al registrar el usuario: " . $stmt->error]);
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
