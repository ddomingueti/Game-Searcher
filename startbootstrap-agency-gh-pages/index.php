<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Controller/PublicationController.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";

$controller = new PublicationController();
$r = $controller->findVisitedPubs();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Game Searcher</title>

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
      <a class="heading-jumbo navbar-brand js-scroll-trigger" href="#page-top"></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#filters">Pesquisa por Filtros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#info">Top Jogos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#team">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
      	<div class="intro-heading text-uppercase">Game Searcher</div>
        <div class="intro-lead-in">Um punhado de jogos em um só lugar. Só procurar e filtrar :)</div>

        <form action="results.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="pesquisaPrincipal" id="pesquisaPrincipal" placeholder="Digite o nome do jogo">
            <small id="emailHelp" class="form-text text-muted">Insira o nome de um jogo na caixa acima. Para fazer buscas mais complexas, utilize os filtros abaixo.</small>
          </div>
          
          <a><button type="submit" name="btn" class="btn btn-primary btn-lg btn-xl text-uppercase">Pesquisar</button></a>
        </form>
      </div>
    </div>
  </header>

  <!-- Filtros -->
  <section class="page-section" id="filters">
    <form action="results.php" class="container" method="POST">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Pesquisa por Filtros</h2>
          <h3 class="section-subheading text-muted"></h3>
        </div>
      </div>
      <div class="row text-left">
        <div class="col-md-6">
          <span class="fa-stack fa-2x">
            <i class="fas fa-list fa-stack-1x text-primary"></i>
          </span>
          <h4 class="service-heading">Filtros</h4>
        </div>

        <div class="input-group mb-3"> <label class="input-text">Gênero</label> <!-- DIV NÃO TA FECHADA -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="genero1" id="genero1" placeholder="Gênero 1">
            <input type="text" class="form-control" name="genero2" id="genero2" placeholder="Gênero 2">
            <input type="text" class="form-control" name="genero3" id="genero3" placeholder="Gênero 3">
        </div>

        <label class="input-text" >Tipo de publicação</label>
        <div class="input-group mb-3">
          <select name="tipo_publicacao" class="custom-select" id="inputGroupSelect01">
            <option selected>Escolha</option>
            <option value="game">Jogo</option>
            <option value="dlc">Dlc</option>
          </select>
        </div>

        <label class="input-text">Desenvolvedor</label>
        <div class="input-group mb-3">
        <input type="text" class="form-control" name="dev" id="dev" placeholder="Nome da empresa">
        </div>

        <div class="form-row">
          <div class="col">
            <div class="form-row">
            	<div class="col-md-12">
              	<label class="input-text" >Preço Min</label>
              </div>
            	<div class="col-md-6">
              	<input type="text" class="form-control" placeholder="Apenas Números">
              </div>
          </div>
          </div>
          <div class="col">
          	<div class="form-row">
            	<div class="col-md-6">
            		<label class="input-text" >Preço Max</label>
          		</div>
          		<div class="col-md-6">
            		<input type="text" class="form-control" placeholder="Apenas Números">
            	</div>
            </div>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-lg btn-x2 text-uppercase">Pesquisar</button>

    </form>
  </section>

  <!-- Info -->
  <section class="page-section" id="info">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Top Jogos</h2>
          <h3 class="section-subheading text-muted">O que há em alta por aqui</h3>
        </div>
      </div>
      <div class="row text-center">
        <div><div class="section col-md-14">
        	<div class="container">
        		<div class="w-layout-grid project-details-grid" style= "text-align: left">
        			<h1>Mais Buscados</h1>
        			<ul>
                        <?php
                            $length = count($controller->getPublication()) > 10 ? 10 : count($controller->getPublication());
                            for ($i=0; $i<$length; $i++) {
                                echo "<li>".$controller->getPublication()[$i]->getGame()->getName().'<span class="badge badge-primary badge-pill">'.$controller->getPublication()[$i]->getNumSearches().'</span></li>';
                            }
                        ?>
                    </ul>
        </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Team -->
  <section class="bg-light page-section" id="team">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Equipe de Desenvolvimento</h2>
          <h3 class="section-subheading text-muted"></h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="team-member">
            <h4>Aladjah</h4>
            <p class="text-muted">Lead Developer - Granduando em Ciência da Computação</p>
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
        </div>
        <div class="col-sm-3">
          <div class="team-member">
            <h4>Daniel</h4>
            <p class="text-muted">Lead Developer - Mestrando em Ciência da Computação</p>
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
        </div>
        <div class="col-sm-3">
          <div class="team-member">
            <h4>Lucas</h4>
            <p class="text-muted">Lead Developer - Graduando em Ciência da Computação</p>
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
        </div>
        <div class="col-sm-3">
          <div class="team-member">
            <h4>Mariana</h4>
            <p class="text-muted">Lead Designer - Graduanda em Ciência da Computação</p>
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
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <p class="large text-muted">Trabalho desenvolvido durante o semestre de 2019/2 durante a disciplina de Banco de Dados (UFSJ) ministrada pelo Prof. Dr. Leonardo Rocha</p>
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