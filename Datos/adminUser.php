<?php
session_start();

// Validar que haya sesión y rol
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['rol']) || $_SESSION['usuario']['rol'] !== 'admin') {
    die("Acceso denegado.");
}
?>
<?php
$host = 'localhost';
$db = 'draftosaurio';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexión fallida: ".$conn->connect_error);
?>
<?php
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    // Evitar que se borre a sí mismo
    if ($delete_id === (int) $_SESSION['usuario']['id']) {
        $_SESSION['message'] = "No puedes borrarte a ti mismo.";
    } else {
        $stmt = $conn->prepare("DELETE FROM usuario WHERE Id_usuario=?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $_SESSION['message'] = "Usuario eliminado correctamente.";
    }
    header("Location: adminUser.php");
    exit();
}
?>
<?php
$result = $conn->query("SELECT Id_usuario, Nombre_jugador, Gmail, Rol FROM usuario ORDER BY Id_usuario ASC");
?>

<h2>Lista de usuarios</h2>

<?php
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">'.htmlspecialchars($_SESSION['message']).'</div>';
    unset($_SESSION['message']);
}
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while($user = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['Id_usuario']); ?></td>
            <td><?php echo htmlspecialchars($user['Nombre_jugador']); ?></td>
            <td><?php echo htmlspecialchars($user['Gmail']); ?></td>
            <td><?php echo htmlspecialchars($user['Rol']); ?></td>
            <td>
                <?php if ($user['Id_usuario'] != $_SESSION['usuario']['id']): ?>
                    <a href="adminUser.php?delete_id=<?php echo $user['Id_usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que querés borrar este usuario?');">Eliminar</a>
                <?php else: ?>
                    <span class="text-muted">No se puede borrar</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>