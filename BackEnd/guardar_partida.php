<?php
session_start();
header('Content-Type: application/json');

// Configuración de base de datos
$host = 'localhost';
$db = 'draftosaurio';
$user = 'root';
$pass = '';

// Conexión a la base
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit();
}

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Obtener datos JSON del body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['jugadores']) || !is_array($data['jugadores']) || count($data['jugadores']) === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos inválidos o faltantes']);
    exit();
}

// Validar que cada jugador tenga id_usuario y puntuacion
foreach ($data['jugadores'] as $jugador) {
    if (!isset($jugador['id_usuario']) || !isset($jugador['puntuacion'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Datos de jugador incompletos']);
        exit();
    }
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // 1. Crear nueva partida
    $sql_partida = "INSERT INTO Partida VALUES ()";
    if (!$conn->query($sql_partida)) {
        throw new Exception('Error al crear la partida: ' . $conn->error);
    }
    
    $id_partida = $conn->insert_id;
    
    // 2. Insertar registros en Juega para cada jugador
    $stmt = $conn->prepare("INSERT INTO Juega (Punt_jug, Id_usuario, Id_partida) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception('Error al preparar statement: ' . $conn->error);
    }
    
    foreach ($data['jugadores'] as $jugador) {
        $puntuacion = intval($jugador['puntuacion']);
        $id_usuario = intval($jugador['id_usuario']);
        
        $stmt->bind_param('iii', $puntuacion, $id_usuario, $id_partida);
        
        if (!$stmt->execute()) {
            throw new Exception('Error al insertar jugador en Juega: ' . $stmt->error);
        }
    }
    
    $stmt->close();
    
    // Confirmar transacción
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Partida guardada exitosamente',
        'id_partida' => $id_partida
    ]);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
