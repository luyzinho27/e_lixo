//VALIDAÇÃO DE CAMPOS
$(function () {
    $("#cadastrarUsuarios").validate();
});

//VALIDAÇÃO DE CAMPOS
$("#cadastrarUsuarios").validate({
    rules: {
        nome_usuario: {
            required: true
        },

        matricula: {
            required: true,
            minlength: 14
        },

        email: {
            required: true,
        },
        perfil: {
            required: true
        }
    },
    messages: {
        nome_usuario: {
            required: "Por favor, informe o seu nome de usuário!"
        },

        matricula: {
            required: "Por favor, informe o seu Cpf!",
            minlength: "Por favor, insira os 11 números do CPF!"
        },

        email: {
            required: "Por favor, informe o seu e-mail!",
            email: "Por favor, informe um e-mail válido!"
        },
        perfil: {
            required: "Por favor, informe o seu perfil!"
        }
    }
});

//FUNÇÃO PARA HABILITAR O CAMPO DIGITE AQUI
document.body.querySelector("#digite").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 1 ? false : true;
});
document.body.querySelector("#pesquisaCadastro1").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 14 ? false : true;
});

function exibir_ocultar(val) {
    if (val.value === 'nome_usuario') {
        document.getElementById('digite').style.display = 'block';
        document.getElementById('pesquisaCadastro1').style.display = 'none';

        document.getElementById("buscar").disabled = true;
        document.getElementById("digite").value = "";
        document.getElementById("digite").disabled = false;

    } else if (val.value === 'matricula') {
        document.getElementById('digite').style.display = 'none';
        document.getElementById('pesquisaCadastro1').style.display = 'block';

        document.getElementById("buscar").disabled = true;
        document.getElementById("pesquisaCadastro1").value = "";
        document.getElementById("pesquisaCadastro1").disabled = false;

    } else {

        document.getElementById("buscar").disabled = false;
        document.getElementById("digite").value = "";
        document.getElementById("pesquisaCadastro1").disabled = true;
        document.getElementById("digite").disabled = true;
    }
};