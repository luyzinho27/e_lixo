//VALIDAÇÃO DE CAMPOS
$(function () {
    $("#login_user_servidor").validate();
});

//VALIDAÇÃO DE CAMPOS
$("#login_user_servidor").validate({
    rules: {
        nome_usuario: {
            required: true
        },

        matricula: {
            required: true,
            minlength: 14
        },

        email: {
            required: true
        },

        usuario: {
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
        nome_usuario: {
            required: "Por favor, informe seu nome!"
        },
        matricula: {
            required: "Por favor, informe o seu Cpf!",
            minlength: "Por favor, insira os 11 números do CPF!"
        },
        email: {
            required: "Por favor, informe o seu e-mail!",
            email: "Por favor, informe um e-mail válido! Ex: exemplo@exemplo.com"
        },
        usuario: {
            required: "Por favor, informe o seu usuario!"
        },
        senha: {
            required: "Por favor, informe uma senha!",
            minlength: "Por favor, digite uma senha com no mínimo 6 caracteres!"
        },
        nova_senha: {
            required: "Por favor, confirme a sua senha!"
        }
    }
});