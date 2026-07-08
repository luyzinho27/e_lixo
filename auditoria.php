<!DOCTYPE html>
<?php
include './acoes_internas_sistema.php';
?>

<!-- container -->
<div class="container">

    <article class="col-sm-12 maincontent">
        <h3 style="text-align: center; font-weight: bold">Auditoria</h3>
        <div class="table-responsive" style="overflow: scroll; overflow-wrap: break-word; height:20em; width: 100%;">

            <table class="table table-sm table-striped table-hover">
                <thead style="background-color: #007375">
                    <tr style="color: #FFF">
                        <th class="int3">Ítem</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Cpf</th>
                        <th scope="col">Acão</th>
                        <th scope="col">Tabela</th>
                        <th scope="col">Data</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Antes</th>
                        <th scope="col">Depois</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado_auditoria) { ?>
                        <?php while ($row = mysqli_fetch_array($resultado_auditoria)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nome_usuario']; ?></td>
                                <td><?php echo $row['cpf']; ?></td>
                                <td><?php echo $row['acao']; ?></td>
                                <td><?php echo $row['tabela']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($row['data_acao'])); ?></td>
                                <td><?php echo $row['hora_acao']; ?></td>
                                <td><?php echo $row['antes_acao']; ?></td>
                                <td><?php echo $row['depois_acao']; ?></td>
                            </tr>
                        <?php }
                        ?>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <br>
        <?php
        $quan_row = '';
        if ($resultado_auditoria) {
            $quan_row = mysqli_num_rows($resultado_auditoria);
        }
        ?>
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
    </article>
    <article class="col-sm-12 maincontent" style="margin-bottom: 10.3%">
        <h4 class="thin text-center">Pesquisar</h4>
        <hr style="margin-bottom: 3%;margin-top: 1%">
        <form action="?p=auditoria" method="post" name="bus">
            <div class="row margin-top">
                <div class="form-group col-sm-5 col-md-5">
                    <select id="opc" name="opcao" class="form-control" onchange="exibir_ocultar(this)">
                        <option  value = "nome_usuario">Nome
                        <option  value = "data_acao">Data
                        <option  value = "hora_acao">Hora
                        <option  value = "acao">Ação
                        <option  value = "geral">Exibir tudo
                        <option selected value = "#" disabled="">Selecione uma opção
                    </select>
                </div>
                <div class="form-group col-sm-5 col-md-5">
                    <input id="digite" class="form-control" type="text" name="termo" placeholder="Digite aqui" disabled="">
                    <input id="digite1" class="form-control" style="display: none" type="date" name="termo" disabled="">
                    <input id="digite2" class="form-control" style="display: none" type="text" name="termo" disabled="">
                    <select id="digite3" name="termo" style="display: none" class="form-control">
                        <option  value = "insercao">Inserção
                        <option  value = "alteracao">Alteração
                        <option  value = "remocao">Remoção
                        <option selected value = "#" disabled="">Selecione uma opção
                    </select>
                </div>

                <div class="form-group col-sm-2 col-md-2">
                    <button disabled id="buscar"  type="submit" name="buscar_auditoria" class="btn btn-info" value="BUSCAR">
                        Pesquisar
                    </button>
                </div>
            </div>
        </form>
    </article>
    
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/js_auditoria.js"></script>
    <script src="js/bootstrap.js"></script>
</div>	<!-- /container -->