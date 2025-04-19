
document.addEventListener("DOMContentLoaded", function () {
    const opciones = document.querySelectorAll(".pa-trayecto-opcion");
    const selectorTrayecto = document.querySelector(".pa-selector-trayecto");
    const formularioAeropuertoHotel = document.getElementById("form-aeropuerto-hotel");
    const formularioHotelAeropuerto = document.getElementById("form-hotel-aeropuerto");
    const formularioIdaVuelta = document.getElementById("form-ida-vuelta");
    const tituloSelector = document.getElementById("h2-selector");
    const tituloTrayecto = document.getElementById("titulo-trayecto");
    const botonesCambiarTrayecto = document.querySelectorAll(".pa-btn-cambiar-trayecto");

    
    

    opciones.forEach(opcion => {
        opcion.addEventListener("click", () => {
            const tipo = opcion.getAttribute("data-tipo");

            // Oculta todos los formularios
            formularioAeropuertoHotel.style.display = "none";
            formularioHotelAeropuerto.style.display = "none";
            formularioIdaVuelta.style.display = "none";

            // Muestra el formulario correspondiente
            if (tipo === "aeropuerto-hotel") {
                formularioAeropuertoHotel.style.display = "block";
            } else if (tipo === "hotel-aeropuerto") {
                formularioHotelAeropuerto.style.display = "block";
            } else if (tipo === "ida-vuelta") {
                formularioIdaVuelta.style.display = "block";
            }
            selectorTrayecto.style.display = "none";
            tituloSelector.style.display = "none";

            botonesCambiarTrayecto.forEach(boton => {
                boton.style.display = "inline-block";
            });
        

            if (tipo === "aeropuerto-hotel") {
                formularioAeropuertoHotel.style.display = "block";
                tituloTrayecto.textContent = "Trayecto aeropuerto a hotel";
            } else if (tipo === "hotel-aeropuerto") {
                formularioHotelAeropuerto.style.display = "block";
                tituloTrayecto.textContent = "Trayecto hotel a aeropuerto";
            } else if (tipo === "ida-vuelta") {
                formularioIdaVuelta.style.display = "block";
                tituloTrayecto.textContent = "Trayecto de ida y vuelta";
            }

            tituloTrayecto.style.display = "block";
        });
    });

    botonesCambiarTrayecto.forEach(boton => {
        boton.addEventListener("click", () => {
            // Oculta formularios
            formularioAeropuertoHotel.style.display = "none";
            formularioHotelAeropuerto.style.display = "none";
            formularioIdaVuelta.style.display = "none";
    
            // Muestra el selector y el título principal
            selectorTrayecto.style.display = "flex";
            tituloSelector.style.display = "block";
    
            // Oculta título de trayecto
            tituloTrayecto.style.display = "none";
        });
    });
});
