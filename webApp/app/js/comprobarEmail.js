document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        const emailInput = form.querySelector(".email-cliente");
        const extraFields = form.querySelector(".datos-viajero-adicionales");

        if (!emailInput || !extraFields) return;

        let emailExiste = false;

        emailInput.addEventListener("blur", function () {
            const email = emailInput.value.trim();

            if (email !== "") {
                fetch(`../controller/comprobarEmail.php?email=${encodeURIComponent(email)}`)
                    .then(res => res.json())
                    .then(data => {
                        emailExiste = data.exists;

                        if (emailExiste) {
                            extraFields.style.display = "none";
                        } else {
                            extraFields.style.display = "block";
                        }
                    })
                    .catch(err => {
                        console.error("Error comprobando email:", err);
                    });
            }
        });

        form.addEventListener("submit", function (e) {
            if (!emailExiste) {
                const campos = extraFields.querySelectorAll("input");

                for (const campo of campos) {
                    if (!campo.value.trim()) {
                        e.preventDefault();
                        alert("El email no está registrado. Por favor, completa todos los datos del viajero.\nLuego pulsa de nuevo 'Confirmar reserva'");
                        return;
                    }
                }
            }
        });
    });
});


/* con ID

document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email-cliente");
    const extraFields = document.getElementById("datos-viajero-adicionales");
    const form = document.querySelector("form");

    let emailExiste = false;

    if (!emailInput || !extraFields || !form) return;

    emailInput.addEventListener("blur", function () {
        const email = emailInput.value.trim();

        if (email !== "") {
            fetch(`../controller/comprobarEmail.php?email=${encodeURIComponent(email)}`)
                .then(res => res.json())
                .then(data => {
                    emailExiste = data.exists;

                    if (emailExiste) {
                        extraFields.style.display = "none";
                    } else {
                        extraFields.style.display = "block";
                    }
                })
                .catch(err => {
                    console.error("Error comprobando email:", err);
                });
        }
    });

    form.addEventListener("submit", function (e) {
        // Solo validamos los campos adicionales si el email no existe
        if (!emailExiste) {
            const nombre = document.getElementById("nombre");
            const apellido1 = document.getElementById("apellido1");
            const apellido2 = document.getElementById("apellido2");
            const direccion = document.getElementById("direccion");
            const codigoPostal = document.getElementById("codigoPostal");
            const ciudad = document.getElementById("ciudad");
            const pais = document.getElementById("pais");
            const password = document.getElementById("password");

            if (
                !nombre?.value || !apellido1?.value || !apellido2?.value ||
                !direccion?.value || !codigoPostal?.value ||
                !ciudad?.value || !pais?.value || !password?.value
            ) {
                e.preventDefault();
                alert("El email no está registrado. Por favor, completa todos los datos del viajero.\n Luego pulsa de nuevo 'Confirmar reserva' ");
            }
        }
    });
});*/