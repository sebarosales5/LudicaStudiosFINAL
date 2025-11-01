<?php
session_start();

$host = 'localhost';
$db = 'draftosaurio';
$user = 'adminDB';
$pass = 'Admin1234_';

$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Conexión fallida: ".$conn->connect_error);

// Asegurar charset seguro para entradas/salidas
$conn->set_charset('utf8mb4');

// Obtener y sanitizar inputs
$nombreRaw = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

// Reglas de nombre: NO debe contener espacios ni ningún tipo de whitespace, ni caracteres no permitidos
// Si el usuario ingresó cualquier whitespace (incluye espacios al inicio/fin), rechazamos
if (preg_match('/\s/u', $nombreRaw)) {
    $_SESSION['message'] = "El nombre no puede contener espacios.";
    $_SESSION['error_type'] = 'registro';
    header("Location: ../index.php?error=1");
    exit();
}

// Normalizar nombre: recortar; validar por whitelist completa
$nombreTrim = trim($nombreRaw);
$nombreNorm = $nombreTrim; // no colapsamos espacios, ya que no están permitidos
// Rechazar control chars, espacios y validar whitelist con full match (sin espacios): letras (unicode), números (unicode), punto, guion, guion bajo
if (preg_match('/[\x00-\x1F\x7F]/', $nombreNorm) || preg_match('/\s/u', $nombreNorm) || !preg_match('/^[\p{L}\p{N}._\-]{3,50}$/u', $nombreNorm)) {
    $_SESSION['message'] = "El nombre contiene caracteres no permitidos, incluye espacios o no cumple la longitud (3-50).";
    $_SESSION['error_type'] = 'registro';
    header("Location: ../index.php?error=1");
    exit();
}
$nombre = $nombreNorm;

// Sanitizar y validar correo
$correo = trim($correo);
$correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
$correo = mb_strtolower($correo);
if ($correo === '' || mb_strlen($correo) > 100 || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Correo inválido.";
    $_SESSION['error_type'] = 'registro';
    header("Location: ../index.php?error=1");
    exit();
}

// Validación mínima de contraseña (longitud)
$contrasena = trim($contrasena);
if ($contrasena === '' || strlen($contrasena) < 6 || strlen($contrasena) > 100) {
    $_SESSION['message'] = "La contraseña debe tener entre 6 y 100 caracteres.";
    $_SESSION['error_type'] = 'registro';
    header("Location: ../index.php?error=1");
    exit();
}

// Hash seguro de la contraseña (después de validar)
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

// Verificar si ya existe (comparando por Gmail)
$stmt = $conn->prepare("SELECT Id_usuario FROM usuario WHERE LOWER(Gmail)=LOWER(?) LIMIT 1");
$stmt->bind_param("s",$correo);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows>0){
    $_SESSION['message']="Correo ya registrado.";
    $_SESSION['error_type'] = 'registro';
    header("Location: ../index.php?error=1"); 
    exit();
}
$stmt->close();

// Insertar nuevo usuario
try {
    $stmt = $conn->prepare("INSERT INTO usuario (Nombre_jugador, Gmail, Contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $correo, $contrasenaHash);

    if ($stmt->execute()) {
        $_SESSION['usuario'] = [
            'id' => $conn->insert_id,
            'nombre' => $nombre,
            'correo' => $correo
        ];
        $_SESSION['message'] = "Registro exitoso. Bienvenido " . $nombre;
            $_SESSION['success'] = true;
    } else {
        $_SESSION['message'] = "Error al registrar: " . $stmt->error;
        $_SESSION['error_type'] = 'registro';
        $stmt->close();
        $conn->close();
        header("Location: ../index.php?error=1");
        exit();
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        // Error de entrada duplicada (usuario ya existe)
        $_SESSION['message'] = "El nombre de usuario o correo ya está en uso.";
    } else {
        $_SESSION['message'] = "Error inesperado: " . $e->getMessage();
    }
    $_SESSION['error_type'] = 'registro';
    $stmt->close();
    $conn->close();
    header("Location: ../index.php?error=1");
    exit();
}
$stmt->close();
$conn->close();
header("Location: ../index.php");
exit();




