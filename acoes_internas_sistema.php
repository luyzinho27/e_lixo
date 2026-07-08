<?php

if (!isset($usuario['usuario']) && !isset($usuario['senha'])) {
    header('location:index.php');
}

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


//------------------------------------------------- PRÉ-CADASTRO SERVIDOR -----------------------------------------------//
$consulta_usuario = '';
$query = '';
$opcao;
$termo = '';

$per = filter_input(INPUT_POST, 'perfil');

$dados_busca = filter_input_array(INPUT_POST);

if (isset($dados_busca['buscar_user'])):
    $opcao = $dados_busca['opcao'];
    if ($opcao != 'geral'):
        $termo = $dados_busca['termo'];
    endif;

    switch ($opcao) {
        case 'nome_usuario':
            if ($perfil == 1) {
                $query = "SELECT matricula,nome_usuario,email,id_usuario FROM tb_usuarios  WHERE nome_usuario LIKE '%$termo%' AND perfil = '0'";
            } else {
                $query = "SELECT matricula,nome_usuario,email,id_usuario FROM tb_usuarios WHERE nome_usuario LIKE '%$termo%' AND perfil != '2'";
            }
            break;
        case 'matricula':
            if ($perfil == 1) {
                $query = "SELECT matricula,nome_usuario,email,id_usuario FROM tb_usuarios  WHERE matricula = '$termo' AND perfil = '0'";
            } else {
                $query = "SELECT matricula,nome_usuario,email,id_usuario FROM tb_usuarios  WHERE matricula LIKE '%$termo%' AND perfil != '2'";
            }
            break;
        default:
            if ($perfil == 1) {
                $query = "SELECT matricula,nome_usuario,email,id_usuario FROM tb_usuarios  WHERE perfil = '0'";
            } else {
                $query = "SELECT matricula,nome_usuario,email,id_usuario FROM tb_usuarios  WHERE  perfil != '2'";
            }
            break;
    }
endif;
if ($query) {
    $consulta_usuario = mysqli_query(abrir_conexao(), $query);
}

if (isset($_POST['pre_cadastro_usuario'])) {
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = md5(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
    $confirmar_senha = md5(filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING));
    $id_usuari = filter_input(INPUT_POST, 'use', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);

    $query = mysqli_query($conexao, "select * from tb_usuarios where matricula = '$matricula'")or die(mysqli_error($conexao));

    $row = mysqli_num_rows($query);

    if ($row > 0) {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Usuário já cadastrado no Sistema!</div>";
    } else {
        $inserir = mysqli_query($conexao, "INSERT INTO tb_usuarios(nome_usuario,email, matricula, status, perfil) 
		VALUES('$nome_usuario', '$email','$matricula','$status','$perfil')") or die(mysqli_error($conexao));

        if ($inserir) {
            $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                    . "VALUES('$id_usuari','$cpf','Inserção','tb_usuarios',curdate(),curtime(),null,concat('Nome: ','$nome_usuario',' | ', 'E-mail: ','$email',' | ','Cpf: ','$matricula',' | ','Perfil: ','$perfil',' | ','Status: ','$status','Usuario: ','********',' | ','Senha: ','*********'))") or die(mysqli_error($conexao));


            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso!</div>";
            $nome_usuario = $email = $matricula = '';
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Usuário NÃO cadastrado!</div>";
        }
    }
}

$row = '';
$acao_alterar = filter_input(INPUT_GET, 'alterar_precadastro_usuario');
if (isset($acao_alterar)) {
    $id_usuarios = filter_input(INPUT_GET, 'alterar_precadastro_usuario');
    $alterar_usuario = true;
    $resultado = mysqli_query($conexao, "SELECT * FROM tb_usuarios "
            . "WHERE id_usuario = '$id_usuarios' ") or die(mysqli_error($conexao));

    if (count($resultado) == 1) {
        $row = mysqli_fetch_array($resultado, MYSQLI_BOTH);
        $nome_usuario = $row['nome_usuario'];
        $email = $row['email'];
        $matricula = $row['matricula'];
        $status = $row['status'];
        $perfil = $row['perfil'];
    }
}

$acao_alterar = null;
$acao_alterar = filter_input(INPUT_POST, 'alterar_precadastro_usuario');
if (isset($acao_alterar)) {
    $id_usuarios = filter_input(INPUT_POST, 'id_usuarios', FILTER_SANITIZE_NUMBER_INT);
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $id_usuari = filter_input(INPUT_POST, 'use', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);

    $buscar = mysqli_query($conexao, "select * from tb_usuarios where matricula = '$matricula'")or die(mysqli_error($conexao));
    $rowPre = mysqli_fetch_array($buscar, MYSQLI_BOTH);

    $nome_usuario_antes = $rowPre['nome_usuario'];
    $email_antes = $rowPre['email'];
    $matricula_antes = $rowPre['matricula'];
    $status_antes = $rowPre['status'];
    $perfil_antes = $rowPre['perfil'];


    if (!($nome_usuario == $nome_usuario_antes && $email == $email_antes && $matricula == $matricula_antes && $status == $status_antes)) {
        $resultado = mysqli_query($conexao, "UPDATE tb_usuarios set nome_usuario = '$nome_usuario',
			email = '$email',matricula = '$matricula',status = '$status', 
			perfil = '$perfil' WHERE id_usuario = '$id_usuarios' ")
                or die(mysqli_error($conexao));


        if ($resultado) {
            $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                    . "VALUES('$id_usuari','$cpf','Alterção','tb_usuarios',curdate(),curtime(),concat('Nome: ','$nome_usuario_antes',' | ', 'E-mail: ','$email_antes',' | ','Cpf: ','$matricula_antes',' | ','Perfil: ','$perfil_antes',' | ','Status: ','$status_antes',' | ', 'Usuario: ','*******',' | ','Senha: ','*********'),concat('Nome: ','$nome_usuario',' | ', 'E-mail: ','$email',' | ','Cpf: ','$matricula',' | ','Perfil: ','$perfil',' | ','Status: ','$status','Usuario: ','********',' | ','Senha: ','*********'))") or die(mysqli_error($conexao));


            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Alteração realizada com Sucesso!</div>";
            $nome_usuario = $email = $matricula = '';
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Alteração Nao realizada,TENTE NOVAMENTE!</div>";
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Nenhum campo foi alterado!</div>";
        $nome_usuario = $email = $matricula = '';
    }
}

if (isset($_POST['voltar_cadastrar_usuario'])) {
    header('location: pagina_inicial_usuario.php?p=cadastrar_usuario');
}
//-----------------------------FIM PRÉ-CADASTRO USUÁRIO---------------------------------------------------------//
//------------CADASTRAR TRANSAÇÕES DE USUÁRIOS (ENTREGA DE DISPOSITIVOS ELETRÔNICOS)----------------------------//
$resultado = '';
$query = '';
$opcao;
$termo = '';

$per = filter_input(INPUT_POST, 'perfil');

$dados_busca = filter_input_array(INPUT_POST);

$produtos = mysqli_query(abrir_conexao(), "SELECT id_produto,descricao FROM tb_dispositivos_eletronicos WHERE status = 'ativo' ORDER BY descricao");
$participantes = mysqli_query(abrir_conexao(), "SELECT id_usuario,nome_usuario FROM tb_usuarios where status = 'ativo' ORDER BY nome_usuario");

if (isset($dados_busca['buscar_transacao'])):
    $opcao = $dados_busca['opcao'];
    if ($opcao != 'geral'):
        $termo = $dados_busca['termo'];
    endif;
    if ($perfil != 0) {
        switch ($opcao) {
            case 'nome_usuario':
                $query = "SELECT id_usuario_fk,id_transacao,nome_usuario,quantia,pontuacao,data,descricao FROM tb_transacao "
                        . "INNER JOIN tb_dispositivos_eletronicos ON tb_dispositivos_eletronicos.id_produto = tb_transacao.id_produto_fk "
                        . "INNER JOIN tb_usuarios ON tb_usuarios.id_usuario = tb_transacao.id_usuario_fk "
                        . "WHERE nome_usuario like  '%$termo%' order by data desc ";
                break;
            default:
                $query = "SELECT id_usuario_fk,id_transacao,nome_usuario,quantia,pontuacao,data,descricao FROM tb_transacao "
                        . "INNER JOIN tb_dispositivos_eletronicos ON tb_dispositivos_eletronicos.id_produto = tb_transacao.id_produto_fk "
                        . "INNER JOIN tb_usuarios ON tb_usuarios.id_usuario = tb_transacao.id_usuario_fk  order by data desc ";
                break;
        }
    } else {
        $query = "SELECT id_usuario_fk,nome_usuario,id_transacao,quantia,pontuacao,data,descricao FROM tb_transacao "
                . "INNER JOIN tb_dispositivos_eletronicos ON tb_dispositivos_eletronicos.id_produto = tb_transacao.id_produto_fk "
                . "INNER JOIN tb_usuarios ON tb_usuarios.id_usuario = tb_transacao.id_usuario_fk where id_usuario_fk = '$id_usuario_log' order by data desc";
    }
endif;

if ($query) {
    $resultado_pesquisa = mysqli_query($conexao, $query);
}

$alterar_transacao = false;
$deletar_transacao = false;
$id_produto = '';
$data = '';
$descricao = '';
$id_transacao = '';

$valor_produto = '';
$id_user = '';
$ano = date('Y', time());
$mes = date('m', time());
if (isset($_POST['cadastrar_transacao'])) {
    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
    $quantia = filter_input(INPUT_POST,'quantidade',FILTER_SANITIZE_NUMBER_INT);
    $valor_produt = mysqli_fetch_array(mysqli_query($conexao, "select pontuacao from tb_dispositivos_eletronicos where id_produto = '$id_produto'"), MYSQLI_BOTH) or die(mysqli_error($conexao));
    $valor_produto = $valor_produt['pontuacao'] * $quantia;
    $id_usuarios = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
    $id_usuari = filter_input(INPUT_POST, 'use', FILTER_SANITIZE_NUMBER_INT);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $desc_modelo = filter_input(INPUT_POST, 'desc_modelo', FILTER_SANITIZE_STRING);
    $ano = date('Y', time());
    $mes = date('m', time());
    $id_us = $usuario['nome_usuario'];
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    if ($quantia != 0){
    $inserir = mysqli_query($conexao, "INSERT INTO tb_transacao(data,quantia,pontos,id_usuario_fk,id_produto_fk,status_transacao,desc_modelo) 
		VALUES('$data','$quantia','$valor_produto','$id_usuarios','$id_produto','$status','$desc_modelo')") or die(mysqli_error($conexao));

    $id_transacao1 = mysqli_fetch_array(mysqli_query($conexao, "select max(id_transacao) from tb_transacao where id_usuario_fk = '$id_usuarios'"), MYSQLI_BOTH);
    $id_transacao = $id_transacao1[0];
    
    $d = date("d/m/Y", strtotime($data));
    if ($inserir) {
        $bus_user = $buscar_pontuacao_usuario = mysqli_fetch_array(mysqli_query($conexao, "select nome_usuario from tb_usuarios where id_usuario = '$id_usuarios'"), MYSQLI_BOTH);
        $nome_user = $bus_user['nome_usuario'];
        $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                . "VALUES('$id_us','$cpf','Inserção','tb_transação',CURDATE(),CURTIME(),null,concat('Nome: ','$nome_user',' | ', 'Data: ','$d',' | ','Status: ','$status',' | ','Pontos: ','$valor_produto',' | ','Desc_Modelo: ','$desc_modelo'))") or die(mysqli_error($conexao));

        $buscar_pontuacao_usuario = mysqli_fetch_array(mysqli_query($conexao, "select * from tb_pontuacao"
                . " inner join tb_usuarios on tb_usuarios.id_usuario = tb_pontuacao.id_usuario_tb_fk "
                . "where id_usuario_tb_fk = '$id_usuarios' and year(data) = '$ano' and month(data) = '$mes'"), MYSQLI_BOTH);
        $id_usua = $buscar_pontuacao_usuario['nome_usuario'];
        $da = date("d/m/Y", strtotime($buscar_pontuacao_usuario['data']));
//        $da = date("d/m/Y", strtotime($data));
        $pon = $buscar_pontuacao_usuario['pontuacao'];

        if ($buscar_pontuacao_usuario != null) {
            $buscar_pontos_produto = mysqli_fetch_array(mysqli_query($conexao, "select pontos from tb_transacao where id_transacao = '$id_transacao'"), MYSQLI_BOTH);
            $nova_pontuacao = $buscar_pontuacao_usuario['pontuacao'] + ($buscar_pontos_produto['pontos']);

            $atualiza = mysqli_query($conexao, "update tb_pontuacao set pontuacao = '$nova_pontuacao', data = '$data' where id_usuario_tb_fk = '$id_usuarios' and year(data) = '$ano' and month(data) = '$mes'") or die($conexao);


            if ($atualiza) {
                $buscar_pontuacao_usuario = mysqli_fetch_array(mysqli_query($conexao, "select pontuacao from tb_pontuacao where id_usuario_tb_fk = '$id_usuarios'"), MYSQLI_BOTH);
//                $pont = $buscar_pontuacao_usuario['pontuacao'];
                $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                        . "VALUES('$id_us','$cpf','Inserção','tb_pontuação',curdate(),curtime(),concat('Nome: ','$id_usua',' | ', 'Data: ','$da',' | ','Pontuação: ','$pon'),"
                        . "concat('Nome: ','$id_usua',' | ', 'Data: ','$d',' | ','Pontuação: ','$nova_pontuacao'))") or die(mysqli_error($conexao));


                $atualiza = '';
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Transação cadastrada com sucesso!</div>";
                $id_produto = $nome_usuario = $id_usuarios = $valor_produto = '';
                header('location: pagina_inicial_usuario.php?p=cadastrar_transac');
                die();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Transação NÃO cadastrada!</div>";
            }
        } else {
            $inserir_pontuacao = mysqli_query($conexao, "insert into tb_pontuacao(pontuacao,data,id_usuario_tb_fk)values('$valor_produto','$data','$id_usuarios')") or die(mysqli_error($conexao));
            if ($inserir_pontuacao) {
                $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                        . "VALUES('$id_usuari','$cpf','Inserção','tb_transação',curdate(),curtime(),null,concat('Nome: ','$id_usua',' | ', 'Data: ','$data',' | ','Status: ','$status',' | ','Pontos: ','$valor_produto',' | ','Desc_Modelo: ','$desc_modelo'))") or die(mysqli_error($conexao));

                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Transação cadastrada com sucesso!</div>";
                $id_produto = $nome_usuario = $id_usuarios = $valor_produto = '';
                header('location: pagina_inicial_usuario.php?p=cadastrar_transac ');
                die();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Transação NÃO cadastrada!</div>";
            }
        }
    }
    }else{
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Transação NÃO cadastrada, por favor digite uma quantia maior que zero!</div>";        
    }
}


if (isset($_POST['deletar_transacao'])) {
    $id_transacao = filter_input(INPUT_POST, 'deletar_transacao');
    $resultado = mysqli_query($conexao, "SELECT * FROM tb_transacao WHERE id_transacao = '$id_transacao'") or die(mysqli_error($conexao));

    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
    $valor_produto = filter_input(INPUT_POST, 'valor_produto', FILTER_SANITIZE_NUMBER_INT);
    $id_usuarios = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
    $id_us = $usuario['nome_usuario'];
    $cpf = $usuario['matricula'];

    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $ano = date('Y', time());
    $mes = date('m', time());

    $buscar_pontuacao_usuario = mysqli_fetch_array(mysqli_query($conexao, "select pontuacao from tb_pontuacao where id_usuario_tb_fk = '$id_usuarios' and year(data) = '$ano' and month(data) = '$mes'"), MYSQLI_BOTH);

    $buscar_pontos_produto = mysqli_fetch_array(mysqli_query($conexao, "select pontos from tb_transacao where id_transacao = '$id_transacao'"), MYSQLI_BOTH);

    $busc_trans = mysqli_fetch_array(mysqli_query($conexao, "select * from tb_transacao inner join tb_usuarios on tb_usuarios.id_usuario = tb_transacao.id_usuario_fk where id_transacao = '$id_transacao'"), MYSQLI_BOTH);
    $id_usuari = $busc_trans['nome_usuario'];
    $dat = $busc_trans['data'];
    $statu = $busc_trans['status_transacao'];
    $valor_produ = $busc_trans['pontos'];
    $desc_model = $busc_trans['desc_modelo'];

    $query = "delete from tb_transacao WHERE id_transacao = '$id_transacao' limit 1";

    mysqli_query($conexao, $query) or die(mysqli_error($conexao));

    if (mysqli_affected_rows($conexao)) {
        $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                . "VALUES('$id_us','$cpf','Remoção','tb_transação',curdate(),curtime(),concat('Nome: ','$id_usuari',' | ', 'Data: ','$dat',' | ','Status: ','$statu',' | ','Pontos: ','$valor_produ',' | ','Desc_Modelo: ','$desc_model'),null)") or die(mysqli_error($conexao));

        $nova_pontuacao = $buscar_pontuacao_usuario['pontuacao'] - $buscar_pontos_produto['pontos'];
        $atualiza = mysqli_query($conexao, "update tb_pontuacao set pontuacao = '$nova_pontuacao' where id_usuario_tb_fk = '$id_usuarios' and year(data) = '$ano' and month(data) = '$mes'") or die($conexao);

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Remoção realizada com Sucesso!</div>";

        $alterar_transacao = false;
        $id_produto = $id_usuarios = '';
        header('location: pagina_inicial_usuario.php?p=cadastrar_transac');
        die();
    } else {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Remoção Nao realizada,TENTE NOVAMENTE!</div>";
    }
}

if (isset($_POST['voltar_cadastrar_transacao'])) {
    header('location: pagina_inicial_usuario.php?p=cadastrar_transac');
}
//--------------------------------------- FIM TRANSACOES----------------------------------------------------------------//
//------------------------------------------------ CADASTRO DE PRODUTO ----------------------------------------------//
$resultado = '';
$query = '';
$opcao;
$termo = '';

$per = filter_input(INPUT_POST, 'perfil');

$dados_busca = filter_input_array(INPUT_POST);

if (isset($dados_busca['buscar_produto'])):
    $opcao = $dados_busca['opcao'];
    if ($opcao != 'geral'):
        $termo = $dados_busca['termo'];
    endif;

    switch ($opcao) {
        case 'descricao':
            $query = "SELECT id_produto,descricao,pontuacao FROM tb_dispositivos_eletronicos  WHERE descricao LIKE '%$termo%' order by descricao";
            break;
        default:
            $query = "SELECT id_produto,descricao,pontuacao FROM tb_dispositivos_eletronicos order by descricao";
            break;
    }
endif;
if ($query) {
    $resultado = mysqli_query(abrir_conexao(), $query);
}

$alterar_produto = false;
$pontuacao = '';
$descricao_produto = '';

if (isset($_POST['cadastrar_produto'])) {
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $pontuacao = filter_input(INPUT_POST, 'pontuacao', FILTER_SANITIZE_NUMBER_INT);
    $descricao_produto = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_STRING);
    $id_us = filter_input(INPUT_POST, 'use', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    $buscar = mysqli_query($conexao, "select * from tb_dispositivos_eletronicos where descricao = '$descricao_produto'")or die(mysqli_error($conexao));
    $row = mysqli_num_rows($buscar);

    if($pontuacao != 0){
    if ($row == 0) {
        $inserir = mysqli_query($conexao, "INSERT INTO tb_dispositivos_eletronicos(descricao,pontuacao,status)"
                . "VALUES('$descricao_produto','$pontuacao','$status')") or die(mysqli_error($conexao));
        if ($inserir) {

            $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                    . "VALUES('$id_us','$cpf','Inserção','tb_dispositivos_eletronico',curdate(),curtime(),null,concat('Nome: ','$descricao_produto',' | ', 'Pontuação: ','$pontuacao',' | ','Status: ','$status'))") or die(mysqli_error($conexao));

            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Produto cadastrado com Sucesso!</div>";
            $id_produto = $descricao_produto = $id_classe = $pontuacao = '';
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Produto não cadastrado, TENTE NOVAMENTE!</div>";
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Produto já cadastrado no sistema!</div>";
    }
    }else{
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Produto NÃO cadastrado, por favor digite uma quantia maior que zero!</div>";
    }
}


if (isset($_GET['alterar_produto'])) {
    $id_produto = filter_input(INPUT_GET, 'alterar_produto');
    $alterar_produto = true;
    $buscar = mysqli_query($conexao, "select * from tb_dispositivos_eletronicos where id_produto = '$id_produto'")or die(mysqli_error($conexao));
    $row = mysqli_num_rows($buscar);

    if ($row == 1) {
        $result = mysqli_fetch_array($buscar, MYSQLI_BOTH);
        $status = $result['status'];
        $pontuacao = $result['pontuacao'];
        $descricao_produto = $result['descricao'];
    }
}

if (isset($_POST['alterar_produto'])) {
    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $pontuacao = filter_input(INPUT_POST, 'pontuacao', FILTER_SANITIZE_NUMBER_INT);
    $descricao_produto = filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_STRING);
    $id_us = filter_input(INPUT_POST, 'use', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    //teste
    $buscar = mysqli_query($conexao, "select * from tb_dispositivos_eletronicos where id_produto = '$id_produto'")or die(mysqli_error($conexao));
    $result = mysqli_fetch_array($buscar, MYSQLI_BOTH);
    $statusz = $result['status'];
    $pontuacaoz = $result['pontuacao'];
    $descricao_produtoz = $result['descricao'];

    //fim teste
    if (!($status == $statusz && $pontuacao == $pontuacaoz && $descricao_produto == $descricao_produtoz)) {
        $atualiza = mysqli_query($conexao, "update tb_dispositivos_eletronicos set status = '$status',pontuacao = '$pontuacao',descricao = '$descricao_produto' where id_produto = '$id_produto'") or die(mysqli_error($conexao));
        if (mysqli_affected_rows($conexao)) {

            $inserir = mysqli_query($conexao, "INSERT INTO auditoria(usuario_id,cpf,acao,tabela,data_acao,hora_acao,antes_acao,depois_acao)"
                    . "VALUES('$id_us','$cpf','Alteração','tb_dispositivos_eletronico',curdate(),curtime(),concat('Nome: ','$descricao_produtoz',' | ', 'Pontuação: ','$pontuacaoz',' | ','Status: ','$statusz'),concat('Nome: ','$descricao_produto',' | ', 'Pontuação: ','$pontuacao',' | ','Status: ','$status'))") or die(mysqli_error($conexao));


            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Produto alterado com sucesso!</div>";
            $id_produto = $descricao_produto = $pontuacao = '';
        } else {
            $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Alteração não realizada, TENTE NOVAMENTE!</div>";
        }
    } else {
        $id_produto = $descricao_produto = $pontuacao = '';
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>Nenhum campo foi alterado!</div>";
    }
}

if (isset($_POST['voltar_cadastrar_produto'])) {
    header('location: pagina_inicial_usuario.php?p=cadastrar_produto');
}
//------------------------------------------------ FIM CADASTRO DE PRODUTO ----------------------------------------------//
//------------------------------------------------- VISUALIZAR TRANSAÇÕES DE PARTICIPANTES --------------------------------//
$y = date('Y', time());
$m = date('m', time());
//$visualizar_transacoes_participante = '';
$visualizar_transacoes_participante = mysqli_query($conexao, "SELECT tb_transacao.id_transacao,tb_dispositivos_eletronicos.pontuacao,tb_transacao.data,
        tb_dispositivos_eletronicos.descricao,tb_transacao.quantia,tb_transacao.pontos FROM tb_transacao INNER JOIN tb_dispositivos_eletronicos 
        ON tb_dispositivos_eletronicos.id_produto = tb_transacao.id_produto_fk 
        WHERE id_usuario_fk = '$id_usuario_log' and status_transacao = 'ativo' and year(tb_transacao.data) = '$y' and month(tb_transacao.data) = '$m' order by id_transacao asc limit 100");

if (isset($_POST['visualizar'])) {
    $mes = filter_input(INPUT_POST, 'mes', FILTER_SANITIZE_NUMBER_INT);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);

    $visualizar_transacoes_participante = mysqli_query($conexao, "SELECT tb_transacao.id_transacao,tb_dispositivos_eletronicos.pontuacao,tb_transacao.data,
        tb_dispositivos_eletronicos.descricao,tb_transacao.quantia,tb_transacao.pontos FROM tb_transacao INNER JOIN tb_dispositivos_eletronicos 
        ON tb_dispositivos_eletronicos.id_produto = tb_transacao.id_produto_fk
        WHERE id_usuario_fk = '$id_usuario_log' and status_transacao = 'ativo' and year(tb_transacao.data) = '$ano' and month(tb_transacao.data) = '$mes' order by id_transacao asc limit 100");
}
//------------------------------------------------- FIM VISUALIZAR TRANSAÇÕES DE PARTICIPANTES --------------------------------//
$query_auditoria = '';
$resultado_auditoria = mysqli_query($conexao, "select * from auditoria inner join tb_usuarios on tb_usuarios.nome_usuario = auditoria.usuario_id order by id desc limit 100");
$dados_busca = filter_input_array(INPUT_POST);
if (isset($dados_busca['buscar_auditoria'])):
    $opcao = $dados_busca['opcao'];
    if ($opcao != 'geral'):
        $termo = $dados_busca['termo'];
    endif;

    switch ($opcao) {
        case 'nome_usuario':
            $query_auditoria = "SELECT * FROM auditoria inner join tb_usuarios on tb_usuarios.nome_usuario = auditoria.usuario_id WHERE nome_usuario like  '%$termo%' order by usuario_id";
            break;
        case 'data_acao':
            $query_auditoria = "SELECT * FROM auditoria inner join tb_usuarios on tb_usuarios.nome_usuario = auditoria.usuario_id WHERE data_acao = '$termo' order by id desc";
            break;
        case 'hora_acao':
            $query_auditoria = "SELECT * FROM auditoria inner join tb_usuarios on tb_usuarios.nome_usuario = auditoria.usuario_id WHERE hora_acao like '$termo%' order by hora_acao desc";
            break;
        case 'acao':
            $query_auditoria = "SELECT * FROM auditoria inner join tb_usuarios on tb_usuarios.nome_usuario = auditoria.usuario_id WHERE acao = '$termo' order by id desc";
            break;
        default:
            $query_auditoria = "select * from auditoria inner join tb_usuarios on tb_usuarios.nome_usuario = auditoria.usuario_id order by id desc";
    }

endif;

if ($query_auditoria) {
    $resultado_auditoria = mysqli_query($conexao, $query_auditoria);
}