<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ludica Studios</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light text-center py-5">

<!-- titulo -->
  <h2 class="mb-4 text-success">¡EN CONSTRUCCIÓN! Vuelva el 15 de septiembre</h2>
  <div id="contador" class="fs-3 text-dark fw-bold"></div>

  <script>
    const destino = new Date("2025-11-15T00:00:00").getTime();

    const actualizarContador = () => {
      const ahora = new Date().getTime();
      const diferencia = destino - ahora;

      if (diferencia <= 0) {
        document.getElementById("contador").textContent = "¡Ya llegó el 15 de septiembre!";
        clearInterval(intervalo);
        return;
      }

      const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
      const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
      const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

      document.getElementById("contador").textContent =
        `${dias} días, ${horas}h ${minutos}m ${segundos}s`;
    };

    const intervalo = setInterval(actualizarContador, 1000);
    actualizarContador(); // Mostrar de inmediato sin esperar 1 segundo

    
  </script>
 <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
