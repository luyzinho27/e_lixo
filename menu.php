<?php
$perfil = $usuario['perfil'];
?>
<link rel="stylesheet" href="css/estilo.css" />
<ul class="nav navbar-nav pull-right">
    <?php if ($perfil == 0) { ?>
        <li class="active"><a href="pagina_inicial_usuario.php">Home</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=cadastrar_transac">Cadastrar Transações</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=visualizar_transacoes">Minhas Transações</a></li>
        <li class="active"><a href="sair.php">Sair</a></li>
    <?php } elseif ($perfil == 1) { ?>
        <li class="active"><a href="pagina_inicial_usuario.php">Home</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=cadastrar_produto">Cadastrar dispositivos</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=cadastrar_transac">Cadastrar Transações</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=visualizar_transacoes">Minhas Transações</a></li>
        <li class="active"><a href="sair.php">Sair</a></li>
    <?php } else { ?>
        <li class="active"><a href="pagina_inicial_usuario.php">Home</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=cadastrar_usuario">Cadastrar Usuários</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=cadastrar_produto">Cadastrar dispositivos</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=cadastrar_transac">Cadastrar Transações</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=visualizar_transacoes">Minhas Transações</a></li>
        <li class="active"><a href="pagina_inicial_usuario.php?p=auditoria">Auditoria</a></li>
        <li class="active"><a href="sair.php">Sair</a></li>
        <?php } ?>    
</ul>   