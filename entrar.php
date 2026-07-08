<!DOCTYPE html>
<?php
session_start();
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
        <script type="text/javascript" src="assets/jq/jquery-3.3.1.js"></script>
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
                        <li><a href="ranking.php">Ranking</a></li>                
                        <li><a href="cadastro.php">Cadastre-se</a></li>
                        <li class="active"><a class="btn" href="entrar.php">Entrar</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div> 
        <!-- /.navbar -->

        <header id="head" class="secondary"></header>
        <div class="fundo">
            <!-- container -->
            <div class="container" style="margin-bottom: 13.8%;">

                <div style="margin-top: 2.5%" class="row">

                    <!-- Article main content -->
                    <article class="col-xs-12 maincontent">

                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div style="background: #F7F5F4" class="panel-body">
                                    <h3 style="margin-top: 0%" class="thin text-center"><strong>Fazer Login</strong></h3>
                                    <p style="font-size: 1em;line-height: 1.3em" class="text-center text-muted">Usuário, Caso ainda não possua cadadastro <a href="cadastro.php">Cadastre-se</a> para que possar fazer login!</p>
                                    <hr>
                                    <?php
                                    if (isset($_SESSION['msg'])) {
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    }
                                    ?>

                                    <form id="autenticar_usuario" method="post" action="autenticar_usuarios.php">
                                        <div class="top-margin">
                                            <label>Usuário<span class="text-danger"></span></label>
                                            <input type="text" name="usuario" maxlength="60" class="form-control" required="">
                                        </div>
                                        <div class="top-margin" id="pass">
                                            <label>Senha <span class="text-danger"></span></label><br>
                                            <img style="width: 4.9%; margin-top: 8px; margin-left: -30px; cursor: pointer;" src="assets/images/visivel.jpg"/>                                          
                                            <input type="password" name="senha" id="senha" class="form-control" maxlength="32" required style="float: left;">
                                        </div><br>

                                        <div style="margin-top: 6%;" class="row">
                                            <div class="col-lg-8">
                                                <b><a href="recuperar_senha.php">Esqueci minha Senha!</a></b>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <button class="btn btn-success" name="fazer_login" type="submit">Entrar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- /Article -->
                </div>
            </div>	<!-- /container -->

            <footer style="margin-top: 4.2%" id="footer" class="top-space">
                <div style="background: #00A2A4;" class="footer2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 widget">
                                <div class="widget-body">
                                    <p id="pfooter" class="text-center">
                                        Copyright &copy; 2019, 
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

        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/js_entrar.js"></script>
        <script src="assets/js/bootstrap.js"></script>
        <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="assets/js/headroom.min.js"></script>
        <script src="assets/js/jQuery.headroom.min.js"></script>
        <script src="assets/js/template.js"></script>
    </body>
</html>