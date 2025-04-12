document.addEventListener('DOMContentLoaded', () => {
    const zonaSelect = document.getElementById('id-zona');
    const hotelSelect = document.getElementById('id-hotel');

    zonaSelect.addEventListener('change', function() {
        const zonaId = this.value;
        fetch(`../controller/getHotelesZona.php?id_zona=${zonaId}`)
            .then(response => response.json())
            .then(data => {
                hotelSelect.innerHTML = '<option value="" disabled selected>Selecciona un hotel</option>';
                data.forEach(hotel => {
                    const option = document.createElement('option');
                    option.value = hotel.id_hotel;
                    option.textContent = hotel.nombre_hotel;
                    hotelSelect.appendChild(option);
                });
            });
    });
});