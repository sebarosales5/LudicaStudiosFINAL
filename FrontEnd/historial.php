<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    $_SESSION['message'] = 'Debes iniciar sesión para ver tu historial de partidas.';
    $_SESSION['error_type'] = 'login';
    header('Location: ../index.php?error=1');
    exit();
}

$host = 'localhost';
$db = 'draftosaurio';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

$currentUserId = intval($_SESSION['usuario']['id']);

// Traer todas las partidas en las que participó el usuario con todos los jugadores y sus puntajes
$sql = "
SELECT j.Id_partida, j.Id_usuario, j.Punt_jug, u.Nombre_jugador
FROM Juega j
JOIN usuario u ON u.Id_usuario = j.Id_usuario
WHERE j.Id_partida IN (
  SELECT Id_partida FROM Juega WHERE Id_usuario = ?
)
ORDER BY j.Id_partida DESC, j.Punt_jug DESC, j.Id_usuario ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $currentUserId);
$stmt->execute();
$res = $stmt->get_result();

$partidas = [];
while ($row = $res->fetch_assoc()) {
    $pid = $row['Id_partida'];
    if (!isset($partidas[$pid])) {
        $partidas[$pid] = [
            'id' => $pid,
            'jugadores' => [],
            'max' => null
        ];
    }
    $punt = intval($row['Punt_jug']);
    $partidas[$pid]['jugadores'][] = [
        'id_usuario' => intval($row['Id_usuario']),
        'nombre' => $row['Nombre_jugador'],
        'puntos' => $punt
    ];
    if ($partidas[$pid]['max'] === null || $punt > $partidas[$pid]['max']) {
        $partidas[$pid]['max'] = $punt;
    }
}
$stmt->close();
$conn->close();

// Calcular ganadores por partida (puede haber empate)
foreach ($partidas as &$p) {
    $max = $p['max'];
    $ganadores = array_values(array_filter($p['jugadores'], function($j) use ($max) { return $j['puntos'] === $max; }));
    $p['ganadores'] = $ganadores;
}
unset($p);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Historial de partidas</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Draftosaurus</a>
    <div class="ms-auto d-flex gap-2 align-items-center">
      <button id="langToggle" class="btn btn-outline-secondary" type="button">EN</button>
      <a href="../index.php" class="btn btn-outline-secondary" data-i18n="nav.back">Volver</a>
      <a href="../BackEnd/logout.php" class="btn btn-outline-danger" data-i18n="nav.logout">Cerrar sesión</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <h1 class="h3 mb-4" data-i18n="history.title">Historial de partidas</h1>

  <?php if (empty($partidas)): ?>
    <div class="alert alert-info" data-i18n="history.empty">Todavía no registraste partidas.</div>
  <?php else: ?>
    <div class="accordion" id="historialAccordion">
      <?php $i = 0; foreach ($partidas as $pid => $p): $i++; ?>
        <?php
          $youPlayed = false;
          foreach ($p['jugadores'] as $j) { if ($j['id_usuario'] === $currentUserId) { $youPlayed = true; break; } }
          $ganadorNombres = implode(', ', array_map(function($g){ return htmlspecialchars($g['nombre']); }, $p['ganadores']));
        ?>
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading<?= $i ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
              <span data-i18n="history.matchIdPrefix">Partida #</span><?= htmlspecialchars($p['id']) ?> • <span data-i18n="history.winners">Ganador(es):</span> <strong><?= $ganadorNombres ?></strong>
            </button>
          </h2>
          <div id="collapse<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $i ?>" data-bs-parent="#historialAccordion">
            <div class="accordion-body">
              <div class="table-responsive">
                <table class="table table-sm align-middle">
                  <thead>
                    <tr>
                      <th data-i18n="history.player">Jugador</th>
                      <th class="text-end" data-i18n="history.points">Puntos</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($p['jugadores'] as $j): ?>
                      <?php $isWinner = ($j['puntos'] === $p['max']); ?>
                      <tr class="<?= $isWinner ? 'table-success' : '' ?>">
                        <td>
                          <?= htmlspecialchars($j['nombre']) ?>
                          <?php if ($j['id_usuario'] === $currentUserId): ?>
                            <span class="badge bg-secondary ms-2" data-i18n="history.you">Tú</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-end">
                          <span class="fw-semibold"><?= htmlspecialchars((string)$j['puntos']) ?></span>
                          <?php if ($isWinner): ?>
                            <span class="badge bg-success ms-2" data-i18n="history.winner">Ganador</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./i18n.js"></script>
<script src="./index.js"></script>
</body>
</html>
