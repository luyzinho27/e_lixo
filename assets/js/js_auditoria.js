//FUNÇÃO PARA HABILITAR O CAMPO DIGITE AQUI
document.body.querySelector("#digite").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 1 ? false : true;
});
document.body.querySelector("#digite1").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 1 ? false : true;
});
document.body.querySelector("#digite2").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 1 ? false : true;
});
document.body.querySelector("#digite3").addEventListener("input", function () {
    var campo_digiteAqui = document.body.querySelector("#buscar");
    campo_digiteAqui.disabled = this.value.length >= 1 ? false : true;
});

function exibir_ocultar(val) {

    if (val.value === 'nome_usuario') {
        document.getElementById("digite").style.display = 'block';
        document.getElementById("digite1").style.display = 'none';
        document.getElementById("digite2").style.display = 'none';
        document.getElementById("digite3").style.display = 'none';

        document.getElementById("buscar").disabled = true;
        document.getElementById("digite").value = "";
        document.getElementById("digite").disabled = false;

    } else if (val.value === 'acao') {
        document.getElementById("digite").style.display = 'none';
        document.getElementById("digite1").style.display = 'none';
        document.getElementById("digite2").style.display = 'none';
        document.getElementById("digite3").style.display = 'block';

        document.getElementById("buscar").disabled = true;
        document.getElementById("digite").value = "";
        document.getElementById("digite").disabled = false;

    } else if (val.value === 'data_acao') {
        document.getElementById("digite").style.display = 'none';
        document.getElementById("digite1").style.display = 'block';
        document.getElementById("digite2").style.display = 'none';
        document.getElementById("digite3").style.display = 'none';

        document.getElementById("buscar").disabled = true;
        document.getElementById("digite1").value = "";
        document.getElementById("digite1").disabled = false;

    } else if (val.value === 'hora_acao') {
        document.getElementById("digite").style.display = 'none';
        document.getElementById("digite1").style.display = 'none';
        document.getElementById("digite2").style.display = 'block';
        document.getElementById("digite3").style.display = 'none';

        document.getElementById("buscar").disabled = true;
        document.getElementById("digite2").value = "";
        document.getElementById("digite2").disabled = false;
    } else {
        document.getElementById("digite").style.display = 'block';
        document.getElementById("digite1").style.display = 'none';
        document.getElementById("digite2").style.display = 'none';
        document.getElementById("digite3").style.display = 'none';

        document.getElementById("buscar").disabled = false;
        document.getElementById("digite").value = "";
        document.getElementById("digite").disabled = true;
    }
}
;


