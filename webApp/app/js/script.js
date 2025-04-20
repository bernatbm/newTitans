document.querySelectorAll(".service").forEach((service, index) => {
service.addEventListener("click", () => {
    // Deselecciona todos los contenedores
    document
    .querySelectorAll(".service")
    .forEach((s) => s.classList.remove("selected"));

    // Selecciona el contenedor actual
    service.classList.add("selected");

    // Muestra un texto diferente según el servicio seleccionado
    switch (index) {
    case 0:
        service.textContent = `¡Ofrecemos un servicio de traslado cómodo y eficiente con nuestras vans estándar, ideales 
                                para grupos pequeños o familias. Equipadas con asientos cómodos y suficiente espacio para 
                                tu equipaje, nuestras vans garantizan un trayecto relajado y seguro desde el aeropuerto hasta 
                                tu hotel o viceversa. Perfecto para quienes buscan comodidad sin sacrificar la practicidad!`;

        break;
    case 1:
        service.innerHTML = `¡Si prefieres un viaje más exclusivo, nuestros coches de lujo con chofer son la opción perfecta. 
                            Viaja con estilo y confort en vehículos de alta gama, equipados con asientos de cuero y un servicio 
                            personalizado. Nuestro chófer profesional se asegurará de que tu trayecto desde el aeropuerto o hacia 
                            el hotel sea lo más placentero posible, ofreciéndote la privacidad y tranquilidad que mereces!`;
        break;
    case 2:
        service.innerHTML =`¡Celebra cualquier ocasión especial con nuestra limusina de lujo, ideal para eventos, bodas o celebraciones. 
                Disfruta del máximo confort y lujo mientras viajas a tu destino con estilo. Nuestra limusina está equipada 
                con todas las comodidades para que tu experiencia sea inolvidable, desde el momento en que te subes hasta que 
                llegas a tu evento. Con un servicio de chofer exclusivo y atención a cada detalle, te aseguramos un trayecto espectacular!`;
        break;
    }
});
});

// Lógica de pestañas
const tabs = document.querySelectorAll('.tab');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));

        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
    });
});

// Función para abrir la pestaña seleccionada
function openTab(tabName) {
    // Ocultar todos los contenidos de las pestañas
    var tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(function(tab) {
        tab.classList.remove('active');
    });

    // Eliminar la clase "active" de todas las pestañas
    var tabLinks = document.querySelectorAll('.tab');
    tabLinks.forEach(function(link) {
        link.classList.remove('active');
    });

    // Mostrar el contenido de la pestaña seleccionada
    document.getElementById(tabName).classList.add('active');

    // Marcar la pestaña seleccionada como "active"
    event.target.classList.add('active');
}

// Mostrar la pestaña "Registrar Usuario" por defecto al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    openTab('usuario');
});

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        alert(error);
        const nuevaURL = window.location.origin + window.location.pathname;
        window.history.replaceState({}, "", nuevaURL); 
    }
});