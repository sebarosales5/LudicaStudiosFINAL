<?php
session_start();

$host = 'localhost';
$db = 'draftosaurio';
$user = 'root';
$pass = '';

$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Conexión fallida: ".$conn->connect_error);

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Hash seguro de la contraseña
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

// Verificar si ya existe
$stmt = $conn->prepare("SELECT * FROM usuario WHERE Gmail=?");
$stmt->bind_param("s",$correo);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows>0){
    $_SESSION['message']="Correo ya registrado.";
    header("Location: ../index.php"); exit();
}

// Insertar nuevo usuario
$stmt = $conn->prepare("INSERT INTO usuario (Nombre_jugador,Gmail,Contraseña) VALUES (?,?,?)");
$stmt->bind_param("sss",$nombre,$correo,$contrasenaHash);
if($stmt->execute()){
    $_SESSION['usuario'] = ['id'=>$conn->insert_id,'nombre'=>$nombre,'correo'=>$correo];
    $_SESSION['message']="Registro exitoso. Bienvenido ".$nombre;
}else{
    $_SESSION['message']="Error al registrar: ".$conn->error;
}
header("Location: ../index.php");
exit();




