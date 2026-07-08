//VALIDAÇÃO DE CAMPOS
$(function () {
    $("#autenticar_usuario").validate();
});

//VALIDAÇÃO DE CAMPOS
$("#autenticar_usuario").validate({
    rules: {
        usuario: {
            required: true
        },

        senha: {
            required: true
        }
    },

    messages: {
        usuario: {
            required: "Por favor, informe o seu usuario!"
        },
        senha: {
            required: "Por favor, informe uma senha!"
        }
    }
});

//MOSTRAR/OCULTAR SENHA
var input = document.querySelector('#pass input');
var img = document.querySelector('#pass img');
img.addEventListener('click', function () {
    input.type = input.type === 'text' ? 'password' : 'text';
});