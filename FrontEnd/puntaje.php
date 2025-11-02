<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">

    <title>Calculadora de Puntaje - Draftosaurus</title>
  </head>
  <body class="bg-custom">
    
    <div class="container py-4">
      <!-- Navegación superior -->
      <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded" style="background-color: #fff8e1;">
        <h2 class="mb-0">Calculadora de Puntaje</h2>
        <button class="btn btn-outline-primary" onclick="window.location.href='../index.php'">Volver al menú</button>
      </div>

      <!-- Contenedor del tablero y controles -->
      <div class="row">
        <!-- Columna izquierda: Tablero del jugador -->
        <div class="col-md-8 mb-4">
          <div class="d-flex justify-content-center mb-3 p-3">
            <div class="mapa" data-player-id="0">
              <img src="../Otros/fotos/Tablero_final.jpg" alt="Mapa zoológico calculadora" class="img-fluid">
              <div class="zona" id="player0-zona1">
                <div class="zona-label"><!--Pradera--></div>
              </div>
              <div class="zona" id="player0-zona2">
                <div class="zona-label"><!--Bosque--></div>
              </div>
              <div class="zona" id="player0-zona3">
                <div class="zona-label"><!--Río--></div>
              </div>
              <div class="zona" id="player0-zona4">
                <div class="zona-label"><!--Montaña--></div>
              </div>
              <div class="zona" id="player0-zona5">
                <div class="zona-label"><!--Desierto--></div>
              </div>
              <div class="zona" id="player0-zona6">
                <div class="zona-label"><!--Costa--></div>
              </div>
              <div class="zona" id="player0-zona7">
                <div class="zona-label"><!--Lago--></div>
              </div>
            </div>
          </div>

          <!-- Pool de dinosaurios -->
          <div id="player0-dinoPool" class="d-flex flex-wrap justify-content-center border border-3 border-danger p-3" style="gap: 10px; background-color: #105c1688;">
            <!-- Los dinosaurios se generarán dinámicamente -->
          </div>
        </div>

        <!-- Columna derecha: Puntajes y controles -->
        <div class="col-md-4">
          <!-- Caja de puntajes -->
          <div class="card mb-3">
            <div class="card-header" style="background-color: #105c16bd; color: white;">
              <h5 class="mb-0">Puntajes por Zona</h5>
            </div>
            <div class="card-body" style="background-color: #fff8e1;">
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <td><strong>Bosque de las Semejanzas:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-pradera">0</span> pts</td>
                  </tr>
                  <tr>
                    <td><strong>Isla Solitaria:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-bosque">0</span> pts</td>
                  </tr>
                  <tr>
                    <td><strong>Rey de la selva:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-rio">0</span> pts</td>
                  </tr>
                  <tr>
                    <td><strong>Trio Frondoso:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-montana">0</span> pts</td>
                  </tr>
                  <tr>
                    <td><strong>Pradera del amor:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-desierto">0</span> pts</td>
                  </tr>
                  <tr>
                    <td><strong>Prado de la Diferencia:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-costa">0</span> pts</td>
                  </tr>
                  <tr>
                    <td><strong>Rio:</strong></td>
                    <td class="text-end"><span id="player0-puntuacion-lago">0</span> pts</td>
                  </tr>
                  <tr class="table-success">
                    <td><strong>TOTAL:</strong></td>
                    <td class="text-end"><strong><span id="player0-puntuacion">0</span> pts</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Caja de controles -->
          <div class="card">
            <div class="card-header" style="background-color: #105c16bd; color: white;">
              <h5 class="mb-0">Controles</h5>
            </div>
            <div class="card-body" style="background-color: #fff8e1;">
              <p class="small text-muted mb-3">Arrastrá los dinosaurios al tablero para calcular los puntos automáticamente.</p>
              <div class="d-grid gap-2">
                <button type="button" class="btn btn-warning" id="btn-limpiar">Limpiar tablero</button>
                <button type="button" class="btn btn-primary" id="btn-agregar-dinos">Agregar dinosaurios</button>
              </div>
              <hr>
              <div class="small">
                <p class="mb-1"><strong>Dinosaurios en tablero:</strong> <span id="player0-dinos-count">0</span></p>
                <p class="mb-1 text-success"><strong>✨ Dinosaurios infinitos disponibles</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Información de reglas -->
      <div class="mt-4 p-3 rounded" style="background-color: #fff8e1;">
        <h5>Reglas de Puntuación</h5>
        <div class="row">
          <div class="col-md-6">
            <ul class="small">
              <li><strong>Bosque de las Semejanzas:</strong> Puntos según el grupo más grande del mismo tipo (2, 4, 8, 12, 18, 24)</li>
              <li><strong>Isla solitaria:</strong> 7 puntos si la especie es única (no aparece en otras zonas)</li>
              <li><strong>Rey de la selva:</strong> 7 puntos si tenés la mayoría de esa especie comparado con otros jugadores</li>
              <li><strong>Trio Frondoso:</strong> 7 puntos si tiene exactamente 3 dinosaurios</li>
            </ul>
          </div>
          <div class="col-md-6">
            <ul class="small">
              <li><strong>Pradera del Amor:</strong> 5 puntos por cada pareja del mismo tipo</li>
              <li><strong>Prado de la diferencia:</strong> Puntos según especies diferentes (1→1, 2→3, 3→6, 4→10, 5→15, 6→21)</li>
              <li><strong>Río:</strong> 1 punto por cada dinosaurio</li>
            </ul>
          </div>
        </div>
      </div>

      <style>
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
        .zona {
          min-height: 60px;
          transition: background-color 0.3s;
        }
        .zona:hover {
          background-color: rgba(255, 153, 0, 0.1);
        }
        
        /* Feedback visual para zonas válidas */
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
        .dino.placed {
          cursor: default;
        }
      </style>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="puntaje.js"></script>
  </body>
</html>