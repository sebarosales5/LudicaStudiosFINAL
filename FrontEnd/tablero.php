<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">

    <title>Partida Draftosaurus</title>
  </head>
  <body class="bg-custom"> <!-- clase para fondo -->
    
    <?php 
    session_start(); 
    $players = isset($_SESSION['players']) ? $_SESSION['players'] : ['Jugador 1', 'Jugador 2'];
    $player_ids = isset($_SESSION['player_ids']) ? $_SESSION['player_ids'] : [0, 0];
    $num_players = count($players);
    ?>
    <div class="container py-4">
      <script>
        // Variables inyectadas desde sesión PHP
        console.log('Sesión PHP:', <?php echo json_encode($_SESSION); ?>);
        const NUM_PLAYERS = <?php echo $num_players; ?>;
        const PLAYER_NAMES = <?php echo json_encode($players); ?>;
        const PLAYER_IDS = <?php echo json_encode($player_ids); ?>;
        console.log('Variables inicializadas:', { NUM_PLAYERS, PLAYER_NAMES, PLAYER_IDS });
      </script>

      <!-- Pestañas de navegación -->
      <ul class="nav nav-tabs mb-4" id="playerTabs" role="tablist" style="background-color: #fff8e1; border-radius: 12px; font-family: 'Poppins', sans-serif; font-weight: 500; font-color: white;">
        <?php foreach($players as $index => $player): ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                  id="player<?php echo $index; ?>-tab" 
                  data-bs-toggle="tab" 
                  data-bs-target="#player<?php echo $index; ?>-pane" 
                  type="button" 
                  role="tab" 
                  aria-controls="player<?php echo $index; ?>-pane" 
                  aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
            <?php echo htmlspecialchars($player); ?>
          </button>
        </li>
        <?php endforeach; ?>
      </ul>

      <!-- Contenido de las pestañas -->
      <div class="tab-content" id="playerTabsContent">
        <?php foreach($players as $index => $player): ?>
        <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" 
             id="player<?php echo $index; ?>-pane" 
             role="tabpanel" 
             aria-labelledby="player<?php echo $index; ?>-tab">
          
          <div class="row">
            <!-- Columna izquierda: Tablero del jugador -->
            <div class="col-md-8 mb-4">
              <div class="d-flex justify-content-center mb-3 p-3">
                <div class="mapa" data-player-id="<?php echo $index; ?>">
                  <img src="../Otros/fotos/Tablero_final.jpg" alt="Mapa zoológico de <?php echo htmlspecialchars($player); ?>" class="img-fluid">
                  <div class="zona" id="player<?php echo $index; ?>-zona1">
                    <div class="zona-label">Pradera</div>
                  </div>
                  <div class="zona" id="player<?php echo $index; ?>-zona2">
                    <div class="zona-label">Bosque</div>
                  </div>
                  <div class="zona" id="player<?php echo $index; ?>-zona3">
                    <div class="zona-label">Río</div>
                  </div>
                  <div class="zona" id="player<?php echo $index; ?>-zona4">
                    <div class="zona-label">Montaña</div>
                  </div>
                  <div class="zona" id="player<?php echo $index; ?>-zona5">
                    <div class="zona-label">Desierto</div>
                  </div>
                  <div class="zona" id="player<?php echo $index; ?>-zona6">
                    <div class="zona-label">Costa</div>
                  </div>
                  <div class="zona" id="player<?php echo $index; ?>-zona7">
                    <div class="zona-label">Lago</div>
                  </div>
                </div>
              </div>

              <!-- Contenedor único para los dinos debajo del tablero (se llenará dinámicamente) -->
              <div id="player<?php echo $index; ?>-dinoPool" class="d-flex flex-wrap justify-content-center border border-3 border-danger p-2" style="gap: 10px; background-color: #105c1688;">
                <!-- dinos generados por JS -->
              </div>
            </div>

            <!-- Columna derecha: dos cajas apiladas -->
            <div class="col-md-4">
              <!-- Caja superior: controles -->
              <div class="card mb-3 position-static" style="top:2rem;">
                <div class="card-header" style="background-color: #105c16bd; color: white;">
                  Controles - <?php echo htmlspecialchars($player); ?>
                </div>
                <div class="card-body" style="background-color: #fff8e1;">
                  <p class="card-text">Botones para controlar la partida.</p>
                  <div id="player<?php echo $index; ?>-dice-holder-indicator" class="mb-2" style="display:none;">
                    <span class="badge bg-warning text-dark">Posee el dado</span>
                  </div>
                  <div id="player<?php echo $index; ?>-dice-face-label" class="small text-muted mb-2"></div>
                  <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" id="player<?php echo $index; ?>-btn-dado">Tirar dado</button>
                  </div>
                </div>
              </div>

              <!-- Caja inferior: información y acciones adicionales -->
              <div class="card">
                <div class="card-header" style="background-color: #105c16bd; color: white;">
                  Información - <?php echo htmlspecialchars($player); ?>
                </div>
                <div class="card-body" style="max-height: 300px; overflow:auto; background-color: #fff8e1;">
                  <h6>Estado del tablero</h6>
                  <ul class="list-unstyled small">
                    <li>Puntuación: <span id="player<?php echo $index; ?>-puntuacion">0</span></li>
                    <li>Dinosaurios colocados: <span id="player<?php echo $index; ?>-dinos-count">0</span></li>
                  </ul>

                  <hr>
                  <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm" id="player<?php echo $index; ?>-btn-mostrar-log">Ver detalles</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Estado global de la partida -->
      <div class="mt-4 p-3 rounded"  style= "background-color: #fff8e1;">
        <h5>Estado global de la partida</h5>
        <div class="row align-items-center">
          <div class="col-md-4">
            <p class="mb-1">Turno actual: <span id="turno-num">1</span></p>
            <p class="mb-1">Jugador activo: <strong id="jugador-activo"><?php echo htmlspecialchars($players[0]); ?></strong></p>
            <p class="mb-1">Poseedor del dado: <strong id="dado-holder"><?php echo htmlspecialchars($players[0]); ?></strong></p>
          </div>
          <div class="col-md-4 text-center">
            <div class="card bg-success text-white">
              <div class="card-body p-2">
                <h6 class="card-title mb-1">Dinosaurios en la bolsa</h6>
                <p class="display-6 mb-0" id="remaining-dinos-count">0</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-end">
          </div>
        </div>
      </div>

      <style>
        /* Estilos para indicador de jugador activo */
        .nav-tabs .nav-link.active-player {
          background-color: #198754;
          color: white;
          border-color: #198754;
        }
        .tab-pane.active-player-content {
          background-color: rgba(25, 135, 84, 0.05);
          border-radius: 0.25rem;
        }
        .nav-tabs .nav-link {
          transition: all 0.3s ease-in-out;
        }
        #remaining-dinos-count {
          font-size: 2rem;
        }
        
        /* Estilos para drag & drop */
        .dino {
          cursor: grab;
          transition: transform 0.2s;
        }
        .dino:active {
          cursor: grabbing;
        }
        .dino.dragging {
          transform: scale(1.05);
          opacity: 0.8;
        }
        .disabled-pool {
          opacity: 0.6;
          pointer-events: none;
        }
        .zona {
          min-height: 60px;
          transition: background-color 0.3s;
        }
        .zona:hover {
          background-color: rgba(255, 153, 0, 0.1);
        }
        
        /* Feedback visual para zonas válidas e inválidas */
        .zona {
          transition: all 0.3s ease;
        }
        .zona-valida {
          transform: scale(1.02);
          background-color: rgba(25, 135, 84, 0.2) !important;
        }
        .zona-invalida {
          background-color: rgba(220, 53, 69, 0.2) !important;
          cursor: not-allowed;
        }

        /* Etiquetas de zona */
        .zona-label {
          position: absolute;
          top: 0;
          left: 0;
          background-color: rgba(16, 92, 22, 0.9);
          color: white;
          padding: 2px 8px;
          border-radius: 4px;
          font-size: 0.8rem;
          pointer-events: none;
          z-index: 10;
          font-family: 'Poppins', sans-serif;
        }

        /* Mejorar visualización de dinosaurios */
        .dino {
          cursor: grab;
          transition: all 0.2s ease;
          padding: 5px;
          border-radius: 8px;
          background-color: rgba(255, 255, 255, 0.1);
        }
        .dino img {
          max-width: 60px;
          height: auto;
        }
        .dino:hover {
          transform: translateY(-2px);
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
      </style>
    </div>

    <!-- Modal de fin de partida -->
    <div class="modal fade" id="modalFinPartida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFinPartidaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalFinPartidaLabel">¡Fin de la Partida!</h5>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <h2 class="display-4">¡Felicitaciones!</h2>
              <h3 id="ganador-nombre" class="text-success"></h3>
              <p class="lead">Ha ganado la partida</p>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Resultados finales:</h5>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">Posición</th>
                    <th scope="col">Jugador</th>
                    <th scope="col">Puntuación</th>
                  </tr>
                </thead>
                <tbody id="tabla-resultados">
                  <!-- Se llenará dinámicamente con JavaScript -->
                </tbody>
              </table>
            </div>
            
            <div class="alert alert-info mt-3" role="alert">
              <strong>✅ Los resultados han sido guardados automáticamente en la base de datos.</strong>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Volver al inicio</button>
          </div>
        </div>
      </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="tablero.js"></script>
  </body>
</html>
