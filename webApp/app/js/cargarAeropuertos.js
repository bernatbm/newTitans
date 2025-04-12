document.addEventListener("DOMContentLoaded", function () {
    const selectAeropuerto = document.getElementById("aeropuerto-destino");

    if (!selectAeropuerto) return;

    fetch("../controller/getAeropuertos.php")
        .then((res) => res.json())
        .then((data) => {
            data.forEach((aero) => {
                const option = document.createElement("option");
                option.value = aero.id_destino;
                option.textContent = aero.aeropuerto;
                selectAeropuerto.appendChild(option);
            });
        })
        .catch((err) => {
            console.error("Error cargando aeropuertos:", err);
        });
});