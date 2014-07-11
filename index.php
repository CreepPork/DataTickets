<!-- DOCTYPE html -->
<head>

	<meta charset="utf-8" />

	<title>Tickets</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css"> <!--BOOTSTRAP -->	
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.css"> <!-- BOOTSTRAP THEME -->
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css"> <!-- DATATABLE -->
	<link rel="stylesheet" type="text/css" href="assets/css/default.css"> <!--DEFAULT CSS -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> <!-- JQUERY -->
	<script type="text/javascript" src="assets/js/bootstrap.js"></script> <!-- BOOTSTRAP JS -->
	<script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script> <!-- DATATABLE JS -->
	<script type="text/javascript" src="assets/js/default.js"></script> <!-- DEFAULT JS -->

	<?php 
	include('rsc/system_arqs/connection.php'); 
	session_start();
	?>
	


</head>
<body>
	<header class="row">
		<div class="col-lg-6 col-md-6 index_title">
			<h1>Datasafer Tickets</h1>
		</div>
		<div class="col-lg-6 col-md-6 index_options">
		<?php
			if(isset($_SESSION['id_logged']) || isset($_SESSION['id_logged_client']) ) { ?>
			<a href="rsc/system_arqs/logout.php"> Logout </a>
			<?php }else{ ?>
			<a data-toggle="modal" data-target="#myModal">
			Login
			</a>
			<?php } ?>

		
		</div>

		





<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4 class="modal-title" id="myModalLabel">Login</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="rsc/system_arqs/actions.php">
       	    <input type="hidden" name="logando" value="1">

        	<div class="form-group">
        	<label for="login">Login</label>
        	<input type="text" name="login" id="login" class="form-control" placeholder="Digite o username">
			</div>

			<div class="form-group">
        	<label for="passwd">Senha</label>
        	<input type="password" name="passwd" id="passwd" class="form-control" placeholder="Digite a senha">
			</div>  

			<div class="form-group">
			<input type="submit" class="btn btn-info" value="Entrar">
			</div>        	
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





    
	</header>
	
		<?php
		if(!isset($_GET['pag'])){
			?>
			<?php if(isset($_SESSION['id_logged'])){
				include('rsc/system_arqs/menu.php');

			}?>
			<div class="container">
			<img src="assets/img/logo.png" class="img-responsive logoImg">
			</div>
			<?php
		}else{
			if(is_file('rsc/pag/'.$_GET['pag'].'.php')){
				include('rsc/pag/'.$_GET['pag'].'.php');
			}else{

				echo '<div class="container"><br><div class="alert alert-warning" role="alert">Página não encontrada</div></div>';
			}
			
		}


		if(isset($_GET['error'])){
			echo '<div class="alert alert-danger" role="alert">Usuário e/ou Senha incorretos</div>';
		}
		?>
	

</body>