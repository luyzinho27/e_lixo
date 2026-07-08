<?php
session_start();

if (isset($_SESSION['usuario'])):
    $usuario = $_SESSION['usuario'];
endif;

$id_usuario_log = $usuario['id_usuario'];
$nome = $usuario['nome_usuario'];
$perfil = $usuario['perfil'];
$pagina = filter_input(INPUT_GET, 'p');

// BLOQUEIA O USUÁRIO TENTAR ENTRAR NO SISTEMA DIGITANDO VIA URL SEM LOGAR
if (!isset($usuario['usuario']) && !isset($usuario['senha'])) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
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
        <script type="text/javascript" src="assets/jq/jquery.mask.min.js"></script>
        <!-- Custom styles for our template -->
        <link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body style="background: #F5FFFA">
        <!-- Fixed navbar -->
        <div style="background: #00A2A4;" class="navbar navbar-inverse navbar-fixed-top headroom" >
            <div class="container">
                <div class="navbar-header">
                    <!-- Button for smallest screens -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" alt="Progressus HTML5 template"></a>
                </div>
                <div class="navbar-collapse collapse">
<?php
include_once ('menu.php');
?>
                </div><!--/.nav-collapse -->
            </div>
        </div> 
        <header id="head" class="secondary"> </header>

<?php
if ($pagina == FALSE) {
    include 'inicio.php';
} else {
    if (isset($pagina)) {
        include_once($pagina . '.php');
    }
}
?>

        <footer style="margin-top: -0.9%" id="footer" class="top-space">
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

        <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="assets/js/headroom.min.js"></script>
        <script src="assets/js/jQuery.headroom.min.js"></script>
        <script src="assets/js/template.js"></script>
    </body>
</html>