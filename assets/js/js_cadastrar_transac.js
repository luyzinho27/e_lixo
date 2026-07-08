//VALIDAÇÃO DE CAMPOS
$(function () {
    $("#cadastrar_transacoes").validate();
});

//VALIDAÇÃO DE CAMPOS
$("#cadastrar_transacoes").validate({
    rules: {
        id_produto: {
            required: true
        },

        id_usuario: {
            required: true
        },
        quantidade: {
            required: true
        },
        des_modelo: {
            required: true
        }
    },

    messages: {
        id_produto: {
            required: "Por favor, informe um produto!"
        },

        id_usuario: {
            required: "Por favor, informe o nome do usuário!"
        },
        quantidade: {
            required: "Por favor, informe um valor inteiro positivo!"
        },
        desc_modelo: {
            required: "Por favor, informe uma descrição!"
        }
    }
});

//FUNÇÃO PARA HABILITAR O CAMPO DIGITE AQUI
document.body.querySelector("#digite").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 1 ? false : true;
});
function verificarOpcao() {
    var opcao = document.getElementById("opc").value;
    if (opcao !== "geral") {
        document.getElementById("buscar").disabled = true;
        document.getElementById("digite").value = "";
        document.getElementById("digite").disabled = false;
    } else {
        document.getElementById("buscar").disabled = false;
        document.getElementById("digite").value = "";
        document.getElementById("digite").disabled = true;
    }
}