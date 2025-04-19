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

