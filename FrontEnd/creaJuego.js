const numPlayersSelect = document.getElementById("numPlayers");
const playersContainer = document.getElementById("playersContainer");
const startButton = document.getElementById("startGame");
const messageDiv = document.getElementById("message");

// Generar inputs al cambiar el dropdown
numPlayersSelect.addEventListener("change", () => {
  playersContainer.innerHTML = "";

  const numPlayers = parseInt(numPlayersSelect.value);

  if (!isNaN(numPlayers) && numPlayers > 0) {
    for (let i = 1; i <= numPlayers; i++) {
      const div = document.createElement("div");
      div.classList.add("col-md-6");

      div.innerHTML = `
        <div class="form-floating">
          <input type="text" class="form-control" id="player${i}" placeholder="Jugador ${i}">
          <label for="player${i}">Nombre del Jugador ${i}</label>
        </div>
      `;
      playersContainer.appendChild(div);
    }
  }
});

// Validar jugadores contra la base de datos
startButton.addEventListener("click", async () => {
  const inputs = playersContainer.querySelectorAll("input");
  const nombres = Array.from(inputs).map(input => input.value.trim());

  if (nombres.some(nombre => nombre === "")) {
    messageDiv.innerHTML = `<span class="text-danger">⚠️ Todos los jugadores deben tener un nombre.</span>`;
    return; // No seguimos si hay campos vacíos
  }

  try {
    // Hacemos la petición al PHP
    const response = await fetch("../BackEnd/verificar_jugadores.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ jugadores: nombres })
    });

    // Depuración: mostrar respuesta cruda
    const responseText = await response.text();
    console.log("Respuesta cruda del servidor:", responseText);

    // Parseamos JSON
    let data;
    try {
      data = JSON.parse(responseText);
    } catch (e) {
      console.error("No se pudo parsear JSON:", e);
      messageDiv.innerHTML = `<span class="text-danger">⚠️ Error al procesar la respuesta del servidor.</span>`;
      return;
    }

    // Lógica según el resultado
    if (data.success) {
      messageDiv.innerHTML = `<span class="text-success">✅ Partida creada con jugadores: ${nombres.join(", ")}</span>`;

      // Solo si todo es válido, redirigimos
      setTimeout(() => {
        window.location.href = "tablero.php";
      }, 500);

    } else {
      messageDiv.innerHTML = `<span class="text-danger">❌ Algunos jugadores no están registrados: ${data.invalid.join(", ")}</span>`;
    }

  } catch (error) {
    messageDiv.innerHTML = `<span class="text-danger">⚠️ Error al conectar con el servidor.</span>`;
    console.error(error);
  }
});


