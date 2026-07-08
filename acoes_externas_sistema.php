<?php

require 'config.php';
require 'conexao.php';
$conexao = abrir_conexao();

$nome_usuario = '';
$status = '';
$matricula = '';
$nome_faculdade = '';
$id_faculdade = '';

$email = '';

$alterar_usuario = false;
$id_usuarios = 0;

$resultado = '';
$resultado_pesquisa = '';
$query = '';
$opcao;
$termo = '';
$id_usuario_logado = '';

//------------------------------------- CADASTRAR LOGIN USUÁRIO SERVIDOR COM VALIDAÇÃO ---------------------------------//
if (isset($_POST['cadastrar_login_servidor'])) {
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario', FILTER_SANITIZE_STRING);
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = md5(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
    $confirmar_senha = md5(filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING));

    $query = mysqli_query($conexao, "SELECT * from tb_usuarios WHERE matricula = '$matricula' and email = '$email'")or die(mysqli_error($conexao));
    $row = mysqli_num_rows($query);

    if ($row == 1) {
        $query = mysqli_query($conexao, "SELECT * from tb_usuarios WHERE matricula = '$matricula'"
                . "and email = '$email' and usuario = '' and senha = ''")or die(mysqli_error($conexao));
        $row = mysqli_num_rows($query);

        if ($row == 1) {
            $query1 = mysqli_query($conexao, "SELECT * from tb_usuarios WHERE usuario = '$usuario'")or die(mysqli_error($conexao));
            $row1 = mysqli_num_rows($query1);
            if ($row1 == 0) {
                if (strlen($senha) < 6) {
                    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Digite uma senha com no mínimo 6 caracteres!</div>";
                } else {
                    if ($senha == $confirmar_senha) {
                        $resultado = mysqli_query($conexao, "UPDATE tb_usuarios set usuario = '$usuario',senha = '$senha' WHERE matricula = '$matricula' and email = '$email'")or die(mysqli_error($conexao));
                        if ($resultado) {
                            //teste
                            $query = mysqli_query($conexao, "SELECT * from tb_usuarios WHERE matricula = '$matricula'");
                            $result = mysqli_fetch_array($query, MYSQLI_BOTH);
                            $id = $result['nome_usuario'];
                            $perfil = $result['perfil'];
                            //fim teste 
                            $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                                    . "VALUES('$id','$matricula','Inserção','tb_usuarios',curdate(),curtime(),null,concat('Nome: ','$nome_usuario',' | ', 'E-mail: ','$email',' | ','Cpf: ','$matricula','| ','Perfil: ','$perfil','| ','Status: ','$status'))") or die(mysqli_error($conexao));

                            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cadastro realizado com Sucesso!</div>";
                            $email = $nome_usuario = $matricula = $usuario = '';
                        } else {
                            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Falha do Sistema, TENTE NOVAMENTE!</div>";
                        }
                    } else {
                        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Senha digitada é diferente de confirmar senha!</div>";
                    }
                }
            } else {
                $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Escolha outro nome para Usuário!</div>";
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Usuário já cadastrado no Sistema!</div>";
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Usuário sem registro, procure a coordenacao do E-Lixo Cametá!</div>";
    }
}
//------------------------------------- FIM  CADASTRAR LOGIN USUÁRIO SERVIDOR COM VALIDAÇÃO ---------------------------------//
//------------------------------------------ CADASTRAR LOGIN USUARIO COMUM ---------------------------------------------//
$usuario = '';
if (isset($_POST['cadastrar_login_comum'])) {
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = md5(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
    $confirmar_senha = md5(filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING));

    $query1 = mysqli_query($conexao, "SELECT * from tb_usuarios WHERE usuario = '$usuario' || matricula = '$matricula'")or die(mysqli_error($conexao));
    $row1 = mysqli_num_rows($query1);

    if ($row1 == 0) {
        if (strlen($senha) < 6) {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Digite uma senha com no mínimo 6 caracteres!</div>";
        } else {
            if ($senha == $confirmar_senha) {
                $inserir = mysqli_query($conexao, "INSERT INTO tb_usuarios(nome_usuario,email, matricula, status, perfil,usuario,senha) 
		VALUES('$nome_usuario', '$email','$matricula','$status','$perfil','$usuario','$senha')") or die(mysqli_error($conexao));
                if ($inserir) {
                    //teste
                    $buscar = mysqli_query($conexao, "select nome_usuario from tb_usuarios where matricula = '$matricula'")or die(mysqli_error($conexao));
                    $result = mysqli_fetch_array($buscar, MYSQLI_BOTH);
                    $id = $result['nome_usuario'];
                    //fim teste   
                    $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                            . "VALUES('$id','$matricula','Inserção','tb_usuarios',curdate(),curtime(),null,concat('Nome: ','$nome_usuario',' | ', 'E-mail: ','$email',' | ','Cpf: ','$matricula','| ','Perfil: ','$perfil','| ','Status: ','$status'))") or die(mysqli_error($conexao));

                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cadastro realizado com Sucesso!</div>";
                    $nome_usuario = $usuario = $email = $matricula = '';
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Falha do Sistema, TENTE NOVAMENTE!</div>";
                }
            } else {
                $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Senha digitada é diferente de confirmar senha!</div>";
            }
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Escolha outro nome para Usuário!</div>";
    }
}
//------------------------------------------ FIM CADASTRAR LOGIN USUARIO COMUM ---------------------------------------------//
//------------------------------------------------ RECUPERAÇÃO DE SENHA DE USUÁRIOS ------------------------------------//
if (isset($_POST['recuperar_acesso'])) {
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = md5(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
    $nova_senha = md5(filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING));

    $query = mysqli_query($conexao, "select * from tb_usuarios where matricula = '$matricula' "
            . "and  email = '$email'");
    $row = mysqli_num_rows($query);

    if ($row == 1) {
        $query = mysqli_query($conexao, "select * from tb_usuarios where matricula = '$matricula' "
                . "and email = '$email' and (usuario <> '' || senha <> '')");
        $row = mysqli_num_rows($query);
        $res = mysqli_fetch_array($query, MYSQLI_BOTH);
        $perfil = $res['perfil'];
        if ($row == 1) {
            if (strlen($senha) < 6) {
                $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Digite sua senha com no mínimo 6 dígitos!</div>";
            } else {
                if ($senha == $nova_senha) {
                    $update = mysqli_query($conexao, "UPDATE tb_usuarios set senha = '$senha' WHERE matricula = '$matricula'") or die(mysqi_error($conexao));
                    if ($update) {
                        //teste
                        $buscar = mysqli_query($conexao, "select id_usuario from tb_usuarios where matricula = '$matricula'")or die(mysqli_error($conexao));
                        $result = mysqli_fetch_array($buscar, MYSQLI_BOTH);
                        $id = $result['nome_usuario'];
                        $cpf = $result['matricula'];

                        //fim teste   
                        $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                                . "VALUES('$id','$cpf','Alteração','tb_usuarios',curdate(),curtime(),null,concat('Nome: ','$nome_usuario',' | ', 'E-mail: ','$email',' | ','Cpf: ','$matricula','| ','Perfil: ','$perfil','| ','Status: ','$status'))") or die(mysqli_error($conexao));

                        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Solicitação realizada com SUCESSO!</DIV>";
                        $matricula = $email = '';
                    } else {
                        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Falha do Sistema, TENTE NOVAMENTE!</div>";
                    }
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-info' role='alert''>Senha digitada é diferente de confirmar senha!</DIV>";
                }
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Usuário não possui login Cadastrado no Sistema!</div>";
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Usuário sem registro, procure a coordenação do E-Lixo Cametá!</div>";
    }
}
//------------------------------------------------ FIM RECUPERAÇÃO DE SENHA DE USUÁRIOS ------------------------------------//
//------------------------------------------------- VISUALIZAR RANKING --------------------------------//

$ano = date('Y', time());
$mes = date('m', time());
if (isset($_POST['visualizar_ranking'])) {
    $mes = filter_input(INPUT_POST, 'mes', FILTER_SANITIZE_NUMBER_INT);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);

    $ranking = mysqli_query($conexao, "SELECT pontuacao,nome_usuario FROM tb_pontuacao inner join tb_usuarios on tb_usuarios.id_usuario = tb_pontuacao.id_usuario_tb_fk where month(data) = '$mes' and year(data) = $ano and pontuacao > 0  order by pontuacao desc") or die($conexao);
}
//------------------------------------------------- FIM VISUALIZAR TRANSAÇÕES DE PARTICIPANTES --------------------------------//