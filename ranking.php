<!DOCTYPE html>
<?php
include './acoes_externas_sistema.php';

$contador = 0;

$ranking = mysqli_query($conexao, "SELECT pontuacao,nome_usuario FROM tb_pontuacao inner join tb_usuarios on tb_usuarios.id_usuario = tb_pontuacao.id_usuario_tb_fk where month(data) = '$mes' and year(data) = $ano and pontuacao > 0  order by pontuacao desc") or die($conexao);
$ano_atual = (int) date('Y', time());
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"    content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
        <title>E-Lixo Cametá</title>
        <link rel="icon" href="assets/images/icone_Elixo.png">
        <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <!-- Custom styles for our template -->
        <link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body>
        <!-- Fixed navbar -->
        <div style="background: #00A2A4;" class="navbar navbar-inverse navbar-fixed-top headroom" >
            <div class="container">
                <div class="navbar-header">
                    <!-- Button for smallest screens -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" alt="Progressus HTML5 template"></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="lixo_eletronico.html">Lixo Tecnológico</a></li>
                        <li><a href="local_coleta.html">Local de Coleta</a></li>
                        <li><a href="pontuacao.php">Pontuando com Lixo</a></li>                
                        <li class="active"><a href="ranking.php">Ranking</a></li>                
                        <li><a href="cadastro.php">Cadastre-se</a></li>
                        <li><a class="btn" href="entrar.php">Entrar</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div> 
        <!-- /.navbar -->

        <header id="head" class="secondary"></header>
        <div class="fundo">
            <!-- container -->
            <div class="container" style="margin-bottom: 14%;">

                <div  style="margin-bottom: 3%; height: 365px" class="row">

                    <!-- Article main content -->
                    <div class="col-md-8 col-md-offset-2">
                        <article class="col-sm-12 maincontent">
                            <h3 style="text-align: center; font-weight: bold">Ranking Gameficação</h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background-color: #007375">
                                        <tr style="color: #FFF">
                                            <th class="int3">Posição</th>
                                            <th class="int3">Participante</th>
                                            <th scope="col">Pontuação</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php while ($row = mysqli_fetch_array($ranking)) { ?>
                                            <tr>
                                                <td><?php echo ++$contador . "ª" ?></td>
                                                <td><?php echo $row['nome_usuario']; ?></td>
                                                <td><?php echo $row['pontuacao']; ?></td>

                                            </tr>
                                        <?php }
                                        ?>

                                    </tbody >
                                </table>
                            </div>
                            <?php
                            $quan_row = '';
                            if ($ranking) {
                                $quan_row = mysqli_num_rows($ranking);
                            }
                            ?>
                            <?php if ($quan_row < 1):
                                ?>
                                <div class="resultado_busca_insucesso" style="margin-top: 8%;text-align: center">
                                    <label>Resultado da busca não encontrou nenhum Registro!</label>
                                </div>
                            <?php endif; ?>
                        </article>

                        <article class="col-xs-12 maincontent">

                            <hr style="margin-bottom: 0%;margin-top: 3%">
                            <h4 class="thin text-center">Pesquisar</h4>
                            <hr style="margin-bottom: 3%;margin-top: 3%">
                            <form action="?p=ranking" method="post" name="bus">
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
                                            <!--<option value = "#" disabled="">Selecione uma opção</option>-->
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-4">
                                        <input type="number" name="ano" class="form-control" value="<?php echo $ano_atual; ?>">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-2">
                                        <button id="buscar"  type="submit" name="visualizar_ranking" class="btn btn-info" value="BUSCAR">
                                            Pesquisar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </article>
                        <!-- /Article -->
                    </div>
                </div>
            </div>	<!-- /container -->

            <footer id="footer" class="top-space">
                <div style="background: #00A2A4;" class="footer2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 widget">
                                <div class="widget-body">
                                    <p id="pfooter" class="text-center">
                                        Copyright &copy; 2014, 
                                        Desenvolvido por discentes da turma Bacharelado em Sistemas de Informações 2016, FASI - Faculdade de Sistemas de Informação<br>
                                        Tv. Padre Antônio Franco, 2790 - Matinha - 68400000, Cameta/PA,
                                        Prédio Orlando Cassique - 2º Andar
                                    </p>
                                </div>
                            </div>
                        </div> <!-- /row of widgets -->
                    </div>
                </div>
            </footer>	
        </div>

        <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="assets/js/headroom.min.js"></script>
        <script src="assets/js/jQuery.headroom.min.js"></script>
        <script src="assets/js/template.js"></script>
    </body>
</html>