<!DOCTYPE html>
<?php
include './acoes_internas_sistema.php';
$uid = '';
?>

<!-- container -->
<div  class="container" style="margin-bottom: 2.9%;">

    <div style="margin-top: 1.5%; margin-bottom: 0%"   class="row">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <div  class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div style="margin-bottom: 0%;" class="panel panel-default">
                    <div style="background: #F7F5F4;" class="panel-body">
                        <?php if (!$alterar_transacao): ?>
                            <h3 style="margin-top: 0%;margin-bottom: 1%" class="thin text-center"><strong>Cadastrar Transações</strong></h3>
                        <?php else: ?> 
                            <h3 style="margin-top: 0%;margin-bottom: 1%" class="thin text-center"><strong>Remover Transações</strong></h3>
                        <?php endif; ?>
                        <hr style="margin-top: 1%;" >
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>

                        <form id="cadastrar_transacoes" method="post" action="?p=cadastrar_transac">
                            <input type="hidden" name="use" value="<?php echo $id_us = $usuario['nome_usuario']; ?>">
                            <input type="hidden" name="cpf" value="<?php echo $cpf = $usuario['matricula']; ?>">
                            <input type="hidden" name="id_transacao" value="<?= $id_transacao ?>">
                            <input type="hidden" name="data" value="<?php echo date('y:m:d', time()); ?>">

                            <div class="row top-margin">
                                <div class="col-sm-6">
                                    <label>Produto</label>
                                    <select id="cb_produto"  name='id_produto' class="form-control" required="">
                                        <option selected value = "#" disabled="">Selecione um dispositivo
                                            <?php
                                            while ($p = mysqli_fetch_array($produtos)) {
                                                $pid = $p['id_produto'];
                                                ?>
                                            <option <?= $id_produto == $pid ? 'selected' : '' ?> value="<?= $pid; ?>"><?= $p['descricao']; ?></option>   
                                            <?php
                                        }
                                        ?>
                                    </select> 
                                </div>
                                <div class="col-sm-3">
                                    <label>Quantidade</label>
                                    <input type="number" name="quantidade" id="quantidade" value="<?php $quantia; ?>" class="form-control" required>
                                </div>
                                <input type="hidden" name="valor_produto" value="<?= $valor_produto ?>">
                                <div class="col-sm-3">
                                    <label>Status</label>
                                    <input class="form-control" type="text" name="status" value="ativo" readonly>
                                </div>
                            </div>
                            <div class="top-margin">
                                <label>Nome do participante</label>

                                <?php if ($usuario['perfil'] != 0): ?>
                                    <select id="cb_produto"  name='id_usuario' class="form-control" required="" >
                                        <option selected value = "#" disabled="">Selecione um participante
                                            <?php
                                            while ($u = mysqli_fetch_array($participantes)) {
                                                $uid = $u['id_usuario'];
                                                ?>
                                            <option <?= $id_usuarios == $uid ? 'selected' : '' ?> value="<?= $uid; ?>"><?= $u['nome_usuario']; ?></option>   
                                        <?php } ?>
                                    </select> 
                                <?php else: ?>
                                    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario_log; ?>">
                                    <input class="form-control" type="text" name="nome_usuario" value="<?php echo $nome; ?>"  readonly="">
                                <?php endif; ?>
                            </div>
                            <div class="top-margin">
                                <label>Descrição</label>
                                <textarea  class="form-control" maxlength="100" name="desc_modelo" placeholder="Ex.: celular marca x, modelo y
Obs: Digite no máximo 100 caracteres" required></textarea>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4 text-right ">
                                    <button class="btn btn-success " name="cadastrar_transacao" type="submit">Cadastrar</button>
                                </div>
                            </div>
                        </form>
                        <hr style="margin-bottom: 0%;margin-top: 3%">
                        <h4 class="thin text-center">Pesquisar</h4>
                        <hr style="margin-bottom: 3%;margin-top: 3%">
                        <form action="?p=cadastrar_transac" method="post" name="bus">
                            <div class="row margin-top">
                                <div class="form-group col-sm-12 col-md-5">
                                    <select id="opc" name="opcao" class="form-control" onchange="verificarOpcao()">
                                        <?php if ($perfil != 0): ?>
                                            <option  value = "nome_usuario">Nome
                                            <option  value = "geral">Exibir todos
                                            <option selected value = "#" disabled="">Selecione uma opção
                                            <?php else: ?>
                                            <option  value = "geral">Exibir todos
                                            <option selected value = "#" disabled="">Selecione uma opção
                                            <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <input id="digite" class="form-control" type="text" name="termo" placeholder="Digite aqui" disabled="">
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <button disabled id="buscar"  type="submit" name="buscar_transacao" style="padding-left: 18px; padding-right: 18px;" class="btn btn-info" value="BUSCAR">
                                        Pesquisar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <?php
                        $quan_row = '';
                        if ($resultado_pesquisa) {
                            $quan_row = mysqli_num_rows($resultado_pesquisa);
                        }
                        ?>

                        <?php if ($quan_row > 0) { ?>
                            <hr>
                            <h4 class="thin text-center">Resultados da Pesquisa</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background-color: #007375">
                                        <tr style="color: #FFF">                                 
                                            <th scope="col">Dispositivo</th>
                                            <th scope="col">Qtd</th>
                                            <th scope="col">Pontução</th>
                                            <th scope="col">Data</th>                                        
                                            <th scope="col">Participante</th>                                        
                                            <th scope="col">Deletar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($resultado_pesquisa) { ?>
                                            <?php while ($row = mysqli_fetch_array($resultado_pesquisa)) { ?>
                                                <tr>                                                    
                                                    <td align="left"><?php echo $row['descricao']; ?></td>
                                                    <td align="center"><?php echo $row['quantia']; ?></td>
                                                    <td align="center"><?php echo $row['pontuacao']; ?></td>
                                                    <td><?php echo date("d/m/Y", strtotime($row['data'])); ?></td>                                 
                                                    <td align="left"><?php echo $row['nome_usuario']; ?></td>                                 
                                                    <td align="center">
                                                        <form method="post" action="?p=cadastrar_transac">
                                                            <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario_fk']; ?>">
                                                            <button type="submit" id="del" name="deletar_transacao" onclick="return confirm('Deseja realmente deletar essa tranzação? Todas os dados dessa transaão serão perdidos!');"
                                                                    style="padding-left: 8px; padding-right: 8px;" class="btn btn-warning" value="<?php echo $row['id_transacao'] ?>">
                                                                Deletar
                                                            </button>
                                                        </form>
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
        <!-- /Article -->
        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/js_cadastrar_transac.js"></script>
        <script src="js/bootstrap.js"></script>
    </div>
    <br>
    <br>
</div>	<!-- /container -->