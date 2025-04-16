function redirigirFormulario(formulario) {
    const estaEnPanel = window.location.pathname.includes('panelAdministrador.php');

    if (estaEnPanel) {
        mostrarFormulario(formulario);
    } else {
        window.location.href = `../admin/panelAdministrador.php?form=${formulario}`;
    }
}

function mostrarFormulario(formulario) {
    const seccion = document.getElementById("options");
    if (seccion) seccion.style.display = "block";

    const h2 = document.getElementById("h2-selector");
    const h3 = document.getElementById("titulo-trayecto");
    if (h2) h2.style.display = "none";
    if (h3) {
        h3.style.display = "block";
        h3.innerText = `Formulario: ${formulario.replace("-", " ")}`;
    }

    const imagenes = {
        "aeropuerto-hotel": "aeroHotel",
        "hotel-aeropuerto": "hotelAero",
        "ida-vuelta": "idaVuelta"
    };

    Object.values(imagenes).forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = "none";
    });

    const imgMostrar = document.getElementById(imagenes[formulario]);
    if (imgMostrar) imgMostrar.style.display = "block";

    const formularios = [
        "form-aeropuerto-hotel",
        "form-hotel-aeropuerto",
        "form-ida-vuelta"
    ];
    formularios.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = "none";
    });

    const formMostrar = document.getElementById("form-" + formulario);
    if (formMostrar) formMostrar.style.display = "block";
}

window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const form = params.get("form");
    if (form) {
        mostrarFormulario(form);
    }
});

 // La función redirigirFormulario ya está en tu archivo script.js, solo asegúrate de que esté correctamente referenciada.
 window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const form = params.get("form");
    if (form) {
        mostrarFormulario(form);
    }
});

// Función para mostrar el formulario según el botón que se haya presionado
function mostrarFormulario(formulario) {
    const seccion = document.getElementById("options");
    if (seccion) seccion.style.display = "block";

    const h2 = document.getElementById("h2-selector");
    const h3 = document.getElementById("titulo-trayecto");
    if (h2) h2.style.display = "none";
    if (h3) {
        h3.style.display = "block";
        h3.innerText = `Formulario: ${formulario.replace("-", " ")}`;
    }

    const imagenes = {
        "aeropuerto-hotel": "aeroHotel",
        "hotel-aeropuerto": "hotelAero",
        "ida-vuelta": "idaVuelta"
    };

    Object.values(imagenes).forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = "none";
    });

    const imgMostrar = document.getElementById(imagenes[formulario]);
    if (imgMostrar) imgMostrar.style.display = "block";

    const formularios = [
        "form-aeropuerto-hotel",
        "form-hotel-aeropuerto",
        "form-ida-vuelta"
    ];
    formularios.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = "none";
    });

    const formMostrar = document.getElementById("form-" + formulario);
    if (formMostrar) formMostrar.style.display = "block";
}