<?php
session_start();

$host = 'localhost';
$db = 'draftosaurio';
$user = 'root';
$pass = '';

// Conexión a la base
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexión fallida: ".$conn->connect_error);

// Validar envío del formulario
if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
    $_SESSION['message'] = "Completa todos los campos.";
    header("Location: ../index.php");
    exit();
}

$correo = $conn->real_escape_string($_POST['correo']);
$contrasena = $_POST['contrasena'];

// Buscar usuario incluyendo rol
$sql = "SELECT Id_usuario, Nombre_jugador, Gmail, Contraseña, 
               COALESCE(Rol,'usuario') AS Rol
        FROM usuario 
        WHERE LOWER(Gmail) = LOWER('$correo') 
        LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($contrasena, $usuario['Contraseña'])) {
        // Guardar sesión con rol seguro
        $_SESSION['usuario'] = [
            'id' => $usuario['Id_usuario'],
            'nombre' => $usuario['Nombre_jugador'],
            'correo' => $usuario['Gmail'],
            'rol' => $usuario['Rol']
        ];
        $_SESSION['message'] = "Bienvenido ".$usuario['Nombre_jugador'];
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['message'] = "Correo o contraseña incorrecta";
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Correo o contraseña incorrecta";
    header("Location: ../index.php");
    exit();
}






