<?php
session_start();

$host = 'localhost'; // o IP del servidor de BD
$db = 'draftosaurio';
$user = 'root';
$pass = '';


// Conexión a la base
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexión fallida: ".$conn->connect_error);
// Asegurar charset seguro
$conn->set_charset('utf8mb4');

// Validar envío del formulario
if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
    $_SESSION['message'] = "Completa todos los campos.";
    $_SESSION['error_type'] = 'login';
    header("Location: ../index.php?error=1");
    exit();
}

// CSRF check
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['message'] = "Solicitud inválida. Refrescá la página e intentá nuevamente.";
    $_SESSION['error_type'] = 'login';
    // Contar como intento fallido
    $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? ($_SESSION['login_attempts'] + 1) : 1;
    if (($_SESSION['login_attempts'] ?? 0) >= 3) {
        $_SESSION['require_captcha'] = true;
    }
    header("Location: ../index.php?error=1");
    exit();
}

$correo = trim($_POST['correo']);
$contrasena = $_POST['contrasena'];
// Validación básica del correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Correo o contraseña incorrecta";
    $_SESSION['error_type'] = 'login';
    $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? ($_SESSION['login_attempts'] + 1) : 1;
    if (($_SESSION['login_attempts'] ?? 0) >= 3) {
        $_SESSION['require_captcha'] = true;
    }
    header("Location: ../index.php?error=1");
    exit();
}

// Captcha requerido si se superó el umbral de intentos
if (!empty($_SESSION['require_captcha']) && $_SESSION['require_captcha'] === true) {
    $captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
    if ($captcha === '' || !isset($_SESSION['captcha_answer']) || $captcha !== $_SESSION['captcha_answer']) {
        $_SESSION['message'] = "Captcha incorrecto.";
        $_SESSION['error_type'] = 'login';
        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? ($_SESSION['login_attempts'] + 1) : 1;
        header("Location: ../index.php?error=1");
        exit();
    }
}

// Buscar usuario incluyendo rol
$stmt = $conn->prepare("SELECT Id_usuario, Nombre_jugador, Gmail, Contraseña, COALESCE(Rol,'usuario') AS Rol FROM usuario WHERE LOWER(Gmail) = LOWER(?) LIMIT 1");
if (!$stmt) {
    $_SESSION['message'] = "Error interno.";
    $_SESSION['error_type'] = 'login';
    header("Location: ../index.php?error=1");
    exit();
}
$stmt->bind_param('s', $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($contrasena, $usuario['Contraseña'])) {
        // Guardar sesión con rol seguro
        // Regenerar ID de sesión para evitar fijación
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        $_SESSION['usuario'] = [
            'id' => $usuario['Id_usuario'],
            'nombre' => $usuario['Nombre_jugador'],
            'correo' => $usuario['Gmail'],
            'rol' => $usuario['Rol']
        ];
        $_SESSION['message'] = "Bienvenido ".$usuario['Nombre_jugador'];
            $_SESSION['success'] = true;
        // Resetear contador y captcha
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['require_captcha'], $_SESSION['captcha_answer']);
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['message'] = "Correo o contraseña incorrecta";
        $_SESSION['error_type'] = 'login';
        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? ($_SESSION['login_attempts'] + 1) : 1;
        if (($_SESSION['login_attempts'] ?? 0) >= 3) {
            $_SESSION['require_captcha'] = true;
        }
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    $_SESSION['message'] = "Correo o contraseña incorrecta";
    $_SESSION['error_type'] = 'login';
    $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? ($_SESSION['login_attempts'] + 1) : 1;
    if (($_SESSION['login_attempts'] ?? 0) >= 3) {
        $_SESSION['require_captcha'] = true;
    }
    header("Location: ../index.php?error=1");
    exit();
}

if (isset($stmt) && $stmt) { $stmt->close(); }
$conn->close();






