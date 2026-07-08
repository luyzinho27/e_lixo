<?php
include_once 'config.php';

function abrir_conexao() {
    $conexao = mysqli_connect(Db_host, Db_user, Db_password, Db_data_base) or die(mysqli_connect_error());
    mysqli_set_charset($conexao, Db_charset)or die(mysqli_connect_error($conexao));
    return $conexao;
}

function fechar_conexao($conexao){
    mysqli_close($conexao)or die (mysqli_connect_error($conexao));
}