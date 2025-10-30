<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Crea partida</title>
      </head>
  <!-- NAV -->
  <body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="ludica.php">Ludica Studios</a>
    </button>
          <img src="../Otros/fotos/dinosaurioperoacolor.jpg" alt="Usuario" width="40" height="40" class="rounded-circle ms-auto" onclick="window.location.href='index.php'">
    </div>
  </div>
</nav>
<!-- formulario de puntajes -->
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container text-center" style="max-width: 400px;">
      
      <h4 class="mb-4 bg-danger py-2 px-2 rounded-1">¡Crea tu partida!</h4>

 <!-- Dropdown de jugadores -->
    <div class="mb-3">
      <label for="numPlayers" class="form-label">Selecciona cantidad de jugadores</label>
      <select class="form-select" id="numPlayers">
        <option value="" selected disabled>Elige una opción</option>
        <option value="2">2 jugadores</option>
        <option value="3">3 jugadores</option>
        <option value="4">4 jugadores</option>
        <option value="5">5 jugadores</option>
      </select>
    </div>

    <!-- Contenedor dinámico de nombres -->
    <div id="playersContainer" class="row g-3"></div>

    <!-- Botón para iniciar partida -->
    <div class="mt-4 text-center">
    <button type="button" class="btn btn-success btn-lg" id="startGame">Jugar</button>
    <!-- Mensajes -->
<div id="message" class="mt-3 text-center fw-bold"></div>

    </div>
  </div>


      

    </div>
  </div>















  <!-- Enlace al JS externo -->
  <script src="creaJuego.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>