<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Controller/PublicationController.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Controller/CommentController.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Comments.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Controller/StoreController.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Store.php";

$op = -1;

if(isset($_GET)){

	$controller = new PublicationController();
	$controller2 = new CommentsController();
	$r = $controller->findPublication($GET['id']);

	$name = $controller->getPublication()->getGame()->getName();
	$store = $controller->getPublication()->getGame()->getStore();
	$resources = $controller->getPublication()->getGame()->getResources();
	$price = $controller->getPublication()->getGame()->getPrice()->getFormated();
	$pubDate = $controller->getPublication()->getGame()->getPubDate();
	$shortDescription = $controller->getPublication()->getGame()->getShortDescription();
	$minimumAge = $controller->getPublication()->getName()->getMinimumAge();
	$isFree = $controller->getPublication()->getGame()->getIsFree();
	$type = $controller->getPublication()->getGame()->getType();
	$developers = $controller->getPublication()->getGame()->getDeveloper();
	$genres = $controller->getPublication()->getGame()->getGenres();
	$requirements =  $controller->getPublication()->getGame()->getRequirements();
	$platforms = $controller->getPublication()->getGame()->getPlatforms();
	$aboutGame = $controller->getPublication()->getGame()->getAboutGame();

}



?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Agency - Start Bootstrap Theme</title>

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
            <a class="nav-link js-scroll-trigger" style="color: orange" href="index.html">Página Inicial</a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
      	<?php echo '<div class="intro-heading text-uppercase">'.$name.'</div>' ?>
        <?php echo '<div class="intro-lead-in">'.$store.'</div>' ?>
      </div>
    </div>
  </header>

  <!-- Info -->
  <section class="page-section" id="info">
    <div class="container">
      <div class="row text-center">
        <div><div class="section col-md-14">
        	<div class="container">
        		<div class="w-layout-grid project-details-grid" style= "text-align: left">
        			<h1>Características</h1>
        			<?php
	        			echo '<ul>
	        				<li>Nome: '.$name.'</li>
	                		<li>Gênero: '.$genres.'</li>
	                		<li>Idade Mínima: '.$minimumAge.'</li>
	        				<li>Data de Publicação: '.$pubDate.'</li>
	        				<li>Preço: '.$price.'</li>
	        				<li>Grátis: '.$isFree.'</li>
	        				<li>Tipo: '.$type.'</li>
	        				<li>Descrição curta: '.$shortDescription.'</li>
	        				<li>Sobre: '.$aboutGame.'</li>
	        				<li>Desenvolvedores '.$developers.'</li>
	        				<li>Loja: '.$store.'</li>
	        				<li>Plataformas: '.$platforms.'</li>
	        			</ul>'
	        		?>
        		</div>
        	</div>
        </div>
        </div>

        <div><div class="section col-md-14">
        	<div class="container">
        		<div class="w-layout-grid project-details-grid" style= "text-align: left">
        			<h1>Requisitos</h1>
        			<?php
        				echo'<h2>Windows</h2>
		        			<ul>
		                		<li>Mínimo: '.$requirements['Pc']->getMinimum().'</li>
		                		<li>Recomendado: '.$requirements['Pc']->getMaximum().'</li>
		        			</ul>
		        		<h2>Mac</h2>
		        			<ul>
		                		<li>Mínimo: '.$requirements['Mac']->getMinimum().'</li>
		                		<li>Recomendado: '.$requirements['Mac']->getMaximum().'</li>
		        			</ul>
		        		<h2>Linux</h2>
		        			<ul>
		                		<li>Mínimo: '.$requirements['Linux']->getMinimum().'</li>
		                		<li>Recomendado: '.$requirements['Linux']->getMaximum().'</li>
		        			</ul>'
		        	?>
        		</div>
        	</div>
        </div>
        </div>
      </div>
      <div class="row text-center">
        <div><div class="section col-md-14">
          <div class="container">
            <div class="w-layout-grid project-details-grid" style= "text-align: left">
              <h1>Comentários</h1>
              <div>
              	<div class="btn-group">
              	  <button type="submit" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	    Lojas
              	  </button>
              	  <div class="dropdown-menu">
              	    <a class="dropdown-item" href="#info" name="OP" value="0">Steam</a>
              	    <a class="dropdown-item" href="#info" name="OP" value="1">GOG</a>
              	  </div>
              	</div>
              	<div class="btn-group">
              	  <button type="submit" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	    Relevância
              	  </button>
              	  <div class="dropdown-menu">
              	    <a class="dropdown-item" href="#info" name="OP" value="2">Recomendados (>3)</a>
              	    <a class="dropdown-item" href="#info" name="OP" value="3">Não Recomendados (<3)</a>
              	  </div>
              	</div>
              	<div class="btn-group">
              	  <button type="submit" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              	    Ordenar
              	  </button>
              	  <div class="dropdown-menu">
              	    <a class="dropdown-item" href="#info" name="OP" value="4">Adicionados Recentemente</a>
              	    <a class="dropdown-item" href="#info" name="OP" value="5">Mais Antigos</a>
              	  </div>
              	</div>
              </div>

              <div class="list-group">


              	<?php 

              		$op = $_POST['OP'];

              		if($op == -1){

              			$comments = $controller2->findByPubId($GET['id']);

              		} else if($op == 0){

              			$comments = $controller2->findSteamComments($GET['id']);

              		} else if($op == 1){

              			$comments = $controller2->findGogComments($GET['id']);

              		} else if($op == 2){

              			$comments = $controller2->findRecommended($GET['id']);

              		} else if($op == 3){

              			$comments = $controller2->findNotRecommended($GET['id']);

              		} else if($op == 4){

              			$comments = $controller2->findByPubIdRecent($GET['id']);

              		} else if($op == 5){

              			$comments = $controller2->findByPubIdOld($GET['id']);

              		}

              		foreach ($comments) {
              				echo '<a class="list-group-item list-group-item">
				                  <div class="d-flex w-100 justify-content-between">
				                    <h5 class="mb-1">'.$comments->getUsername().'</h5>
				                    <small class="text-muted">'.$comments->getDate().'</small>
				                  </div>
				                  <small>'.$comments->getRecomendation().'</small>
				                  <p class="mb-1">'.$comments->getReview().'</p>
				                  <small class="text-muted">'.$comments->getHours().'</small>
				                </a>'
              		}

              	?>

              </div>
            </div>
          </div>
        </div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4">
          <span class="copyright">Copyright &copy; Your Website 2019</span>
        </div>
        <div class="col-md-4">
          <ul class="list-inline social-buttons">
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul class="list-inline quicklinks">
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
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
