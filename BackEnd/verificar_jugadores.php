<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db   = 'draftosaurio';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Error de conexión"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$jugadores = $data["jugadores"] ?? [];

$invalid = [];
$valid_players = [];
$stmt = $conn->prepare("SELECT Id_usuario, Nombre_jugador FROM usuario WHERE Nombre_jugador = ?");
foreach ($jugadores as $nombre) {
    $nombre = trim($nombre);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $invalid[] = $nombre;
    } else {
        $row = $result->fetch_assoc();
        $valid_players[] = [
            'id' => $row['Id_usuario'],
            'nombre' => $row['Nombre_jugador']
        ];
    }
}
$stmt->close();
$conn->close();

if (empty($invalid)) {
    // Guardar en sesión la configuración de la partida con IDs
    $_SESSION['num_players'] = count($valid_players);
    $_SESSION['players'] = array_column($valid_players, 'nombre');
    $_SESSION['player_ids'] = array_column($valid_players, 'id');

    echo json_encode(["success" => true, "num_players" => $_SESSION['num_players']]);
} else {
    echo json_encode(["success" => false, "invalid" => $invalid]);
}

