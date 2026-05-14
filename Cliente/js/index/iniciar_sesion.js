document.addEventListener('DOMContentLoaded', function() {
console.log('entro');
    const correoiniciosesion = document.getElementById('correoiniciosesion');
    const contraseñainiciosesion = document.getElementById('contraseñainiciosesion');
    const btniniciosesion = document.getElementById('btniniciosesion');

    btniniciosesion.addEventListener('click', function() {
        const correo = correoiniciosesion.value;
        const contraseña = contraseñainiciosesion.value;

        if (correo == '' || contraseña == '') {
            Toastify({
                text: "No obtuve un correo",
                duration: 3000,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
                },
            }).showToast();
        }

        $.ajax({
            type: "POST",
            url: "./Servidor/solicitudes/inicio/autentificacion.php",//calcular desde donde se esta importando
            data: {
                correo: correo,
                contra: contraseña
            },
            success: function (response) {

                console.log(response);
                if (response == "No hay nada en los campos") {
                    console.log('No hay nada en los campos');
                }else{
                    if (response == "correcto el inicio de sesion") {
                        window.location.href = './Cliente/interfaces/inicio.php';
                    }
                }
            }
        });
    });
});