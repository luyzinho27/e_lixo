<?php
include './acoes_internas_sistema.php';

$total = mysqli_query($conexao, "SELECT pontuacao FROM tb_pontuacao  WHERE id_usuario_tb_fk = '$id_usuario_log' and year(data) = '$ano' and month(data) = '$mes'")or die(mysqli_error($conexao));
$pontos = mysqli_fetch_array($total, MYSQLI_BOTH);
$ano_atual = (int) date('Y', time());
$cont = 1;
?>

<div class="container" style="margin-bottom: 14.6%;">
    <!-- Article main content --> 
    <article class="col-sm-12 maincontent">
        <h3 style="text-align: center; font-weight: bold">Tabela com minhas transações</h3>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead style="background-color: #007375">
                    <tr style="color: #FFF">
                        <th class="int3">Nº Trans.</th>
                        <th class="int3">Descrição</th>
                        <th class="int3">Quantidade</th>
                        <th class="int3">Pontos</th>
                        <th scope="col">Total </th>
                        <th scope="col">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($visualizar_transacoes_participante)) { ?>
                        <tr>
                            <td><?php echo $cont++; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td><?php echo $row['quantia']; ?></td>
                            <td><?php echo $row['pontuacao']; ?></td>
                            <td><?php echo $row['pontos']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row['data'])); ?></td>
                        </tr>
                    <?php }
                    ?>
                </tbody >
            </table>
        </div>
        <div style="font-weight: bold;color: blue;font-size: 1em" class="col-md-4 col-md-offset-4"><?php echo "Pontuação Total -> " . $pontos['pontuacao']; ?></div>
        <?php
        $quan_row = '';
        if ($visualizar_transacoes_participante) {
            $quan_row = mysqli_num_rows($visualizar_transacoes_participante);
        }
        ?>
        <?php if ($quan_row < 1):
            ?>
            <div class="resultado_busca_insucesso" style="margin-top: 8%;text-align: center">
                <label>Resultado da busca não encontrou nenhum Registro!</label>
            </div>
        <?php endif; ?>
    </article>

    <!--buscas-->
    <article class="col-sm-12 maincontent">
        <hr style="margin-bottom: 0%;margin-top: 3%">
        <h4 class="thin text-center">Pesquisar</h4>
        <hr style="margin-bottom: 3%;margin-top: 3%">
        <form action="?p=visualizar_transacoes" method="post" name="bus">
            <div class="row margin-top">
                <div class="form-group col-sm-12 col-md-4">
                    <select  name="mes" class="form-control">
                        <option <?= $mes == 1 ? 'selected' : '' ?> value = "01">Janeiro</option>
                        <option <?= $mes == 2 ? 'selected' : '' ?> value = "02">Fevereiro</option>
                        <option <?= $mes == 3 ? 'selected' : '' ?> value = "03">Março</option>
                        <option <?= $mes == 4 ? 'selected' : '' ?> value = "04">Abril</option>
                        <option <?= $mes == 5 ? 'selected' : '' ?> value = "05">Maio</option>
                        <option <?= $mes == 6 ? 'selected' : '' ?> value = "06">Junho</option>
                        <option <?= $mes == 7 ? 'selected' : '' ?> value = "07">Julho</option>
                        <option <?= $mes == 8 ? 'selected' : '' ?> value = "08">Agosto</option>
                        <option <?= $mes == 9 ? 'selected' : '' ?> value = "09">Setembro</option>
                        <option <?= $mes == 10 ? 'selected' : '' ?> value = "10">Outubro</option>
                        <option <?= $mes == 11 ? 'selected' : '' ?> value = "11">Novembro</option>
                        <option <?= $mes == 12 ? 'selected' : '' ?> value = "12">Dezembro</option>
                    </select>
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <input type="number" name='ano' class="form-control" value="<?php echo $ano_atual; ?>">
                </div>
                <div class="form-group col-sm-12 col-md-2">
                    <button id="buscar"  type="submit" name="visualizar" class="btn btn-info" value="BUSCAR">
                        Pesquisar
                    </button>
                </div>
            </div>
        </form>

    </article>
</div>	<!-- /container -->