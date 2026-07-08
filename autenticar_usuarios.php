<?php

session_start();
require 'conexao.php';
$conexao = abrir_conexao();

if (isset($_POST['fazer_login'])) {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = md5(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
    $sql = mysqli_query($conexao, "SELECT * FROM tb_usuarios WHERE usuario = '$usuario' and senha = '$senha' and status = 'ativo'")
            or die(mysqli_error($conexao));

    $row = mysqli_num_rows($sql);

    if ($row == 1) {
        $user = mysqli_fetch_array($sql, MYSQLI_ASSOC);
        $_SESSION['usuario'] = $user;
        $perfil = $user['perfil'];
        if ($perfil == 0) {
            header('location: pagina_inicial_usuario.php');
        } else if ($perfil == 1) {
            header('location: pagina_inicial_usuario.php');
        } else {
            header('location: pagina_inicial_usuario.php');
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'> Usuário e/ou senha inválidos!</div >";
        header('location:entrar.php');
    }
} 