<?php

include "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Controller/PublicationController.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/PublicationDao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";

$pesquisa = false;

if (isset($_POST)) {

    $controller = new PublicationController();
    $res = false;

    $genero1 = isset($_POST['genero1']) && $_POST['genero1'] !== '' ? $_POST['genero1'] : null;
    $genero2 = isset($_POST['genero2']) && $_POST['genero2'] !== ''? $_POST['genero2'] : null;
    $genero3 = isset($_POST['genero3']) && $_POST['genero3'] !== ''? $_POST['genero3'] : null;
    $tipo_pub = isset($_POST['tipo_publicacao']) && $_POST['tipo_publicacao'] !== ''? $_POST['tipo_publicacao'] : null;
    $dev = isset($_POST['dev']) && $_POST['dev'] !== '' ? $_POST['dev'] : null;
    $precoMin = isset($_POST['precoMinimo']) && $_POST['precoMinimo'] !== '' ? $_POST['precoMinimo'] : null;
    $precoMax = isset($_POST['precoMaximo']) && $_POST['precoMaximo'] !== '' ? $_POST['precoMaximo'] : null;
    $pesquisaPrincipal = isset($_POST['pesquisaPrincipal']) && $_POST['pesquisaPrincipal'] !== '' ? $_POST['pesquisaPrincipal'] : null;

    if ($pesquisaPrincipal !== null) {
        $res = $controller->findGameName($pesquisaPrincipal);
    } else {
        $res = $controller->customSearch($genero1, $genero2, $genero3, $tipo_pub, $dev, $precoMin, $precoMax);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GS - Resultados da busca</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/agency.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="heading-jumbo navbar-brand js-scroll-trigger" href="#page-top">Game Searcher</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" style="color: orange" href="index.php">Página Inicial</a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Info -->
  <section class="page-section" id="info">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Resultados da Pesquisa</h2>
          <h3 class="section-subheading text-muted">Clique em um link para obter mais informações</h3>
        </div>
      </div>
      <div class="row text-center">
        	<div class="container">
            <?php 
                if (!$res) {
                    echo "<h1>Nenhum resultado encontrado. Tente fazer outra busca.</h1>";
                } else {
            ?>
        		<div class="w-layout-grid project-details-grid" style= "text-align: left">

        		<div class="list-group">
                <ul>
                <?php
                    foreach ($controller->getPublication() as $publication) {
                        echo '<li> <a href="game_result.php?id='.$publication->getPublicationId().'" class="list-group-item list-group-item-action list-group-item-light">'.$publication->getGame()->getName().'-'.$publication->getStore()->getName().'</a></li>';
                    }
                }
                ?>
                </ul>
        		</div>

            </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4">
          <span class="copyright">Copyright &copy; Game Searcher 2019</span>
        </div>
        <div class="col-md-4">
          
        </div>
        <div class="col-md-4">
          <ul class="list-inline quicklinks">
            <li class="list-inline-item">
              <a href="#" style="color: orange">Privacy Policy</a>
            </li>
            <li class="list-inline-item">
              <a href="#" style="color: orange">Terms of Use</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/agency.min.js"></script>

</body>

</html>
