<?php
header("Content-Type: application/json");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbs13591604";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    exit();
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $passUser = md5($_POST['passUser'] ?? '');
    $emailUser = $_POST['emailUser'] ?? '';

    // Preparar la consulta SQL
    $sql = "SELECT nameUser, idUser, dateUser FROM usr WHERE passUser=? AND emailUser=? ";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $passUser, $emailUser);


        // Ejecutar la consulta
        if ($stmt->execute()) {
            header('Location: index.html');
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}

$conn->close();
