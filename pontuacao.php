<!DOCTYPE html>
<?php
require 'config.php';
require 'conexao.php';
$conexao = abrir_conexao();
$resultado = mysqli_query(abrir_conexao(), "select * from tb_dispositivos_eletronicos order by descricao");
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
                        <li class="active"><a href="pontuacao.php">Pontuando com Lixo</a></li>                
                        <li><a href="ranking.php">Ranking</a></li>                
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
            <div class="container">

                <div class="row">

                    <!-- Article main content -->
                    <div class="col-md-8 col-md-offset-2">
                        <article class="col-sm-12 maincontent">
                            <header class="page-header">
                                <h3 style="font-weight: bold" class="page-title">Pontuando com lixo!</h3>
                            </header>

                            <p><img src="assets/images/pontuacaoColeta.jpg" alt="" class="img-rounded pull-right" width="200" >
                                Caso você deseje se cadastrar e participar da maratona do E-Lixo Cametá, cada lixo que você descartar 
                                em nossos pontos de coleta resultarão em pontos para você concorrer a premios ao final
                                da maratona.
                                <br>Cada unidade de lixo coletada tem valor em pontos
                            </p>
                        </article>
                        <article class="col-sm-12 maincontent">
                            <h3 style="text-align: center; font-weight: bold">Tabela de pontos dispositivos Eletrônicos</h3>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover">
                                    <thead style="background-color: #007375">
                                        <tr style="color: #FFF">
                                            <th class="int3">Descrição</th>
                                            <th scope="col">Pontuação</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                            <tr>
                                                <td><?php echo $row['descricao']; ?></td>
                                                <td><?php echo $row['pontuacao']; ?></td>
                                            </tr>
                                        <?php }
                                        ?>

                                    </tbody >
                                </table>
                            </div>
                        </article>
                        <!-- /Article -->
                    </div>                    
                </div>
            </div>	<!-- /container -->

            <footer id="footer" class="top-space">
                <div style="background: #00A2A4;"  class="footer2">
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