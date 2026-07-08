//VALIDAÇÃO DE CAMPOS
$(function () {
    $("#recuperar_login").validate();
});

//VALIDAÇÃO DE CAMPOS
$("#recuperar_login").validate({
    rules: {
        matricula: {
            required: true,
            minlength: 14
        },

        email: {
            required: true
        },

        senha: {
            required: true,
            minlength: 6
        },
        nova_senha: {
            required: true
        }

    },
    messages: {
        matricula: {
            required: "Por favor, informe o seu Cpf!",
            minlength: "Por favor, insira os 11 números do CPF!"
        },
        email: {
            required: "Por favor, informe o seu e-mail!",
            email: "Por favor, informe um e-mail válido!"
        },
        senha: {
            required: "Por favor, informe uma senha!",
            minlength: "Por favor, informe uma senha com no mínimo 6 caracteres!"
        },
        nova_senha: {
            required: "Por favor, confirme sua senha!"
        }
    }
});