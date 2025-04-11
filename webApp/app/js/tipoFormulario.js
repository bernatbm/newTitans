document.addEventListener('DOMContentLoaded', function () {
    const tipoTrayecto = document.getElementById('pa-tipo-trayecto');
    const formAeropuertoHotel = document.getElementById('form-aeropuerto-hotel');
    const formHotelAeropuerto = document.getElementById('form-hotel-aeropuerto');
    const formIdaVuelta = document.getElementById('from-ida-vuelta'); // asegúrate que el ID es correcto

    tipoTrayecto.addEventListener('change', function () {
        formAeropuertoHotel.style.display = 'none';
        formHotelAeropuerto.style.display = 'none';
        formIdaVuelta.style.display = 'none';

        const valor = this.value;

        if (valor === 'aeropuerto-hotel') {
            formAeropuertoHotel.style.display = 'block';
        } else if (valor === 'hotel-aeropuerto') {
            formHotelAeropuerto.style.display = 'block';
        } else if (valor === 'ida-vuelta') {
            formIdaVuelta.style.display = 'block';
        }
    });
});