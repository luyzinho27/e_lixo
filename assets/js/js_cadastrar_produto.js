//VALIDAÇÃO DE CAMPOS
$(function () {
    $("#cadastrar_dispositivos").validate();
});

//VALIDAÇÃO DE CAMPOS
$("#cadastrar_dispositivos").validate({
    rules: {
        descricao_produto: {
            required: true
        },
        pontuacao: {
            required: true
        },

        id_classe: {
            required: true
        }
    },

    messages: {
        descricao_produto: {
            required: "Por favor, informe um produto!"
        },

        pontuacao: {
            required: "Por favor, informe uma pontuação!"
        },

        id_classe: {
            required: "Por favor, informe uma classe!"
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