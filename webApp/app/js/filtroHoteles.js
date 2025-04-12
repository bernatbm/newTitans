document.addEventListener('DOMContentLoaded', () => {
    // Se busca class en lugar de id
    document.querySelectorAll('.pa-form').forEach(form => {
        const zonaSelect = form.querySelector('.pa-input-zona');
        const hotelSelect = form.querySelector('.pa-select-hotel-destino');

        if (!zonaSelect || !hotelSelect) return; 

        zonaSelect.addEventListener('change', function () {
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
                })
                .catch(error => {
                    console.error("Error cargando hoteles:", error);
                    hotelSelect.innerHTML = '<option disabled>Error al cargar hoteles</option>';
                });
        });
    });
});