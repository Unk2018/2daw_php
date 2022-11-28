var intervaloID;
var contador = 0;
var finished = false;

try {
  $(document).ready(function () {
    // Solo lo hace al darle click
    $(".btnContactos").click(function () {
      // Desactiva el botón para evitar llamadas repetidas y lo oculta
      if (finished == false) {
        $(".btnContactos").prop("disabled", true);
        $(".btnContactos").toggle("display");
        // Se repite esta acción hasta que se quiera salir
        intervaloID = setInterval(() => {
          // Al ser mayor de 3, muestra el mensaje que se estaba cargando
          if (contador > 3) {
            $("#cargandoContacto").toggle("display");
            $("#mensajeCargado").toggle("display");
            finished = true;
            clearInterval(intervaloID); // Sale del intervalo
          }

          // Aumenta el contador, indicando que ya lo realizado
          contador++;
        }, 1000);
      }
    });
  });
} catch (error) {
  console.info(error);
}
