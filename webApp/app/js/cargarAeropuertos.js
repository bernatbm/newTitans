document.addEventListener("DOMContentLoaded", function () {
    const selects = document.querySelectorAll(".aeropuerto-select");

    if (!selects.length) return;

    fetch("../controller/getAeropuertos.php")
        .then((res) => res.json())
        .then((data) => {
            selects.forEach(select => {
                // Limpia el select por si acaso
                select.innerHTML = `<option value="" disabled selected>Selecciona un aeropuerto</option>`;

                data.forEach((aero) => {
                    const option = document.createElement("option");
                    option.value = aero.id_destino;
                    option.textContent = aero.aeropuerto;
                    select.appendChild(option);
                });
            });
        })
        .catch((err) => {
            console.error("Error cargando aeropuertos:", err);
        });
});