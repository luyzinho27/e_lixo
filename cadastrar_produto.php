<!DOCTYPE html>
<?php
include './acoes_internas_sistema.php';
?>

<!-- container -->
<div style="margin-bottom: 16%;" class="container">

    <div style="margin-top: 1.5%;margin-bottom: 2%" class="row">

        <!-- Article main content -->
        <article style="margin-bottom: 0%" class="col-xs-12 maincontent">
            <div  class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div  style="margin-bottom: 0%" class="panel panel-default">
                    <div style="background: #F7F5F4;" class="panel-body">
                        <?php if (!$alterar_produto): ?>
                            <h3 style="margin-top: 0%;margin-bottom: 1%" class="thin text-center"><strong>Cadastrar Produto</strong></h3>
                        <?php else: ?>
                            <h3 style="margin-top: 0%;margin-bottom: 1%" class="thin text-center"><strong>Alterar Produto</strong></h3>
                        <?php endif; ?>
                        <hr style="margin-top: 0%">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>

                        <form id="cadastrar_dispositivos" method="post" action="?p=cadastrar_produto">
                            <input type="hidden" name="use" value="<?php echo $id_us = $usuario['nome_usuario']; ?>">
                            <input type="hidden" name="cpf" value="<?php echo $cpf = $usuario['matricula']; ?>">

                            <input type="hidden" name="id_produto" value="<?= $id_produto ?>">
                            <div style="margin-top: 1%" class="row top-margin">
                                <div class="col-sm-8">
                                    <label>Nome</label>
                                    <input type="text" name="descricao_produto" value="<?php echo $descricao_produto; ?>" maxlength="60" class="form-control" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Pontuação</label>
                                    <input id="pontua" type="text" class="form-control" maxlength="3" name="pontuacao" value="<?php echo $pontuacao; ?>">
                                </div>
                            </div>

                            <?php if (!$alterar_produto): ?>
                                <div style="margin-top: 4%; display: none;" class="row top-margin">
                                    <div class="col-sm-4">
                                        <label>Status</label>
                                        <input class="form-control" type="text" name="status" value="ativo" readonly>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div style="margin-top: 4%;display: block"   class="row top-margin">
                                    <div class="col-sm-4">
                                        <label>Status</label>
                                        <select  name="status" class="form-control">
                                            <option  value = "#" disabled>Selecione um status
                                            <option <?= $status == 'ativo' ? 'selected' : '' ?>  value = "ativo">Ativo
                                            <option <?= $status == 'inativo' ? 'selected' : '' ?> value = "inativo">Inativo
                                        </select>
                                    </div>
                                    <div class="col-sm-8 text-right " style="margin-top: 3%">
                                        <button class="btn btn-action " name="alterar_produto" onclick="return confirm('Deseja realmente fazer as alerarções?');"
                                                type="submit">Alterar</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div style="margin-top: 4%" class="row">
                                <div class="col-lg-3 text-right ">
                                    <?php if (!$alterar_produto): ?>
                                        <button class="btn btn-success" name="cadastrar_produto" type="submit">Cadastrar</button>
                                    <?php endif; ?>
                                </div>                               
                            </div>
                        </form>

                        <form id="cadastrar_dispositivo" method="post" action="?p=cadastrar_produto">
                            <?php if ($alterar_produto) { ?>
                                <div  class="col-sm-offset-8 text-right">
                                    <button class="btn btn-sm"  onclick="window.history.back()" name="voltar_cadastr_produto" type="submit">
                                        Voltar
                                    </button>
                                </div>
                            <?php } ?>
                        </form>

                        <hr style="margin-bottom: 3%;margin-top: 3%">
                        <h4 class="thin text-center">Pesquisar</h4>
                        <hr style="margin-bottom: 3%;margin-top: 3%">
                        <form action="?p=cadastrar_produto" method="post" name="bus">
                            <div class="row margin-top">
                                <div class="form-group col-sm-5 col-md-5">
                                    <select id="opc" name="opcao" class="form-control" onchange="verificarOpcao()">
                                        <option  value = "descricao">Nome   
                                        <option  value = "geral">Exibir todos
                                        <option selected value = "#" disabled="">Selecione uma opção
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-md-4">
                                    <input id="digite" class="form-control" type="text" name="termo" placeholder="Digite aqui" disabled="">
                                </div>
                                <div class="form-group col-sm-3 col-md-3">
                                    <button disabled id="buscar"  type="submit" name="buscar_produto" style="padding-left: 18px; padding-right: 18px;" class="btn btn-info" value="BUSCAR">
                                        Pesquisar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <?php
                        $quan_row = '';
                        if ($resultado) {
                            $quan_row = mysqli_num_rows($resultado);
                        }
                        ?>

                        <?php if ($quan_row > 0) { ?>
                            <hr style="margin-top: 1%">
                            <h4 class="thin text-center">Resultados da Pesquisa</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background-color: #007375">
                                        <tr style="color: #FFF">
                                            <th class="int3">Nome</th>
                                            <th scope="col">Pontuação</th>
                                            <th scope="col">Atualizar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($resultado) { ?>
                                            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                <tr>
                                                    <td><?php echo $row['descricao']; ?></td>
                                                    <td><?php echo $row['pontuacao']; ?></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-warning" href="pagina_inicial_usuario.php?p=cadastrar_produto&alterar_produto=<?php echo $row['id_produto'] ?>">
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
    <script src="assets/js/js_cadastrar_produto.js"></script>
    <script src="js/bootstrap.js"></script>   
</div>	<!-- /container -->