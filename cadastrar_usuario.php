<!DOCTYPE html>
<?php
include './acoes_internas_sistema.php';
?>

<!-- container -->
<div  class="container" style="margin-bottom: 11.4%;">

    <div style="margin-top: 1.5%;margin-bottom: 2%" class="row">

        <!-- Article main content -->
        <article style="margin-bottom: 0%" class="col-xs-12 maincontent">

            <div  class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div  style="margin-bottom: 0%" class="panel panel-default">
                    <div style="background: #F7F5F4;" class="panel-body">
                        <?php if (!$alterar_usuario): ?>
                            <h3 style="margin-top: 0%;margin-bottom: 1%" class="thin text-center"><strong>Cadastrar Usuário</strong></h3>
                        <?php else: ?>
                            <h3 style="margin-top: 0%;margin-bottom: 1%" class="thin text-center"><strong>Alterar Usuário</strong></h3>
                        <?php endif; ?>
                        <hr style="margin-top: 0%">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>

                        <form id="cadastrarUsuarios" method="post" action="?p=cadastrar_usuario">
                            <input type="hidden" name="use" value="<?php echo $id_usuari = $usuario['nome_usuario']; ?>">
                            <input type="hidden" name="cpf" value="<?php echo $cpf = $usuario['matricula']; ?>">
                            <input type="hidden" name="id_usuarios" value="<?php echo $id_usuarios; ?>">
                            <div style="margin-top: 1%" class="row top-margin">
                                <div class="col-sm-7">
                                    <label>Nome</label>
                                    <input type="text" name="nome_usuario" value="<?php echo $nome_usuario; ?>" maxlength="60" class="form-control" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Cpf</label>
                                    <input type="text" required class="form-control" id="matricula" name="matricula" maxlength="14" 
                                           value="<?php echo $matricula; ?>" placeholder="CPF">
                                </div>
                            </div>
                            <div  class="top-margin">
                                <label>E-mail</label>
                                <input type="email" name="email" value="<?php echo $email; ?>" maxlength="60" class="form-control" required placeholder="Ex: exemplo@exemplo.com">
                            </div>
                            <?php if (!$alterar_usuario): ?>
                                <div class="row top-margin" style="display: none">
                                    <div class="col-sm-6">
                                        <label>Perfil</label>
                                        <input class="form-control" type="text" name="perfil" value="1" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Status</label>
                                        <input class="form-control" type="text" name="status" value="ativo" readonly>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row top-margin" style="display: block">
                                    <div class="col-sm-4">
                                        <label>Perfil</label>
                                        <input class="form-control" type="text" name="perfil" value="<?php echo $perfil; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Status</label>
                                        <select  name="status" class="form-control" required="">
                                            <option  value = "#" disabled>Selecione um status
                                            <option <?= $status == 'ativo' ? 'selected' : '' ?>  value = "ativo">ativo
                                            <option <?= $status == 'inativo' ? 'selected' : '' ?> value = "inativo">Inativo
                                        </select>
                                    </div>
                                    <div class="col-sm-4 text-right" style="margin-top: 3.2%">
                                        <button class="btn btn-action"  name="alterar_precadastro_usuario" onclick="return confirm('Deseja realmente fazer as alerarções?');"
                                                type="submit">Alterar</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <br>
                            <div class="row">
                                <div class="col-sm-3 text-right">
                                    <?php if ($alterar_usuario == false): ?>
                                        <button class="btn btn-success" name="pre_cadastro_usuario" type="submit">Cadastrar</button>
                                    <?php endif; ?>
                                </div>     
                            </div>
                        </form>
                        <form id="cadastrarUsuarios" method="post" action="?p=cadastrar_usuario">
                            <?php if ($alterar_usuario) { ?>
                                <div class="col-sm-offset-8 text-right">
                                    <button class="btn btn-sm " name="voltar_cadastrar_usuario" type="submit"><i class="fas fa-undo-alt"></i>
                                        Voltar</button>
                                </div>
                            <?php } ?> 
                        </form>

                        <hr style="margin-bottom: 0%;margin-top: 3%">
                        <h4 class="thin text-center">Pesquisar</h4>
                        <hr style="margin-bottom: 3%;margin-top: 3%">
                        <form action="?p=cadastrar_usuario" method="post" name="bus">
                            <div class="row margin-top">
                                <div class="form-group col-sm-5 col-md-5">
                                    <select id="opc" name="opcao" class="form-control" onchange="exibir_ocultar(this)">
                                        <option  value = "nome_usuario">Nome
                                        <option  value = "matricula">Cpf
                                        <option  value = "geral">Exibir todos
                                        <option selected value = "#" disabled="">Selecione uma opção
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-md-4">
                                    <input id="digite" class="form-control" type="text" name="termo" placeholder="Digite aqui" disabled>
                                    <input id="pesquisaCadastro1" class="form-control" type="text" name="termo" placeholder="Digite aqui" disabled style="display: none;">
                                </div>
                                <div class="form-group col-sm-3 col-md-3">
                                    <button disabled id="buscar" style="padding-left: 15px; padding-right: 15px;"
                                            type="submit" name="buscar_user" class="btn btn-info" value="BUSCAR">
                                        Pesquisar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <?php
                        $quan_row = '';
                        if ($consulta_usuario) {
                            $quan_row = mysqli_num_rows($consulta_usuario);
                        }
                        ?>

                        <?php if ($quan_row > 0) { ?>
                            <hr style="margin-top: 1%">
                            <h4 class="thin text-center">Resultados da Pesquisa</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class=" table table-condensed table-striped table-hover">
                                    <thead style="background-color: #007375;">
                                        <tr style="color: #FFF;">
                                            <th class="int3">Cpf</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">E-mail</th>                                        
                                            <th scope="col">Atualizar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($consulta_usuario) { ?>
                                            <?php while ($row = mysqli_fetch_array($consulta_usuario)) { ?>
                                                <tr>
                                                    <td><?php echo $row['matricula']; ?></td>
                                                    <td><?php echo $row['nome_usuario']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>                                 
                                                    <td>
                                                        <a class="btn btn-sm btn-warning" href="pagina_inicial_usuario.php?p=cadastrar_usuario&alterar_precadastro_usuario=<?php echo $row['id_usuario'] ?>">
                                                            Alterar
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        <?php } ?>
                                    </tbody >
                                </table>
                            </div>
                            <?php if ($quan_row > 0):
                                ?>
                                <div class="resultado_busca_sucesso">
                                    <label>Resultado da buscar encontrou <?php echo $quan_row; ?> Registro(s) !</label>
                                </div>
                            <?php else: ?>
                                <div class="resultado_busca_insucesso">
                                    <label>Resultado da busca encontrou <?php echo $quan_row; ?> Registro!</label>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/js_cadastrar_usuario.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</div>	<!-- /container -->