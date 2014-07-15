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
       	    <input type="hidden" name="directLogin" value="1">

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
		if(isset($_POST['token'])){ //TOKEN RECEBIDO DO ART BACKUP
			$ip = getenv("REMOTE_ADDR");
			$ip_query = "SELECT * FROM tck_ip WHERE ip ='".$ip."'";
			$ip_query = mysql_query($ip_query);
			if(mysql_num_rows($ip_query) == 0){
				$stmt = "INSERT INTO tck_ip (ip, vezes) VALUES ('$ip', 1)";
				mysql_query($stmt);
			}else{
				$stmt = "SELECT vezes FROM tck_ip WHERE ip = '$ip'";
				$stmt = mysql_query($stmt);
				$rsc = mysql_fetch_array($stmt);
				$vezes = intval($rsc['vezes']);
				$vezes++;
				
				$stmt = "UPDATE tck_ip SET vezes = ".$vezes." WHERE ip = '".$ip."'";
				mysql_query($stmt);

				$stmt = "SELECT vezes FROM tck_ip WHERE ip = '$ip'";
				$stmt = mysql_query($stmt);
				$rsc = mysql_fetch_array($stmt);
				$vezes = intval($rsc['vezes']);
			}

			if($vezes < 3){


			$stmt = "SELECT * FROM tck_token WHERE cod ='".$_POST['token']."'"; //VERIFICAÇÃO DO TOKEN NA TABELA
			$stmt = mysql_query($stmt);
			if(mysql_num_rows($stmt) > 0){ //SE EXISTIR O TOKEN INFORMADO
				$res = mysql_fetch_array($stmt);
				$query = "SELECT * FROM tck_client WHERE id = ".$res['cliente']; //BUSCAR O USUÁRIO REGISTRADO JUNTO COM O TOKEN INFORMADO
				$query = mysql_query($query);
				$rsc = mysql_fetch_array($query);
				?>	
				<!-- ###################################################################################################### -->
				<?php
				$user = $rsc['user'];
				$pass = $rsc['passwd'];
				?>

				<form action="rsc/system_arqs/actions.php" method="post" name="auto_log_form">
				  <input type="hidden" name="logando" value="1" />
				  <input type="hidden" name="login" value="<?php echo $user?>" />
				  <input type="hidden" name="passwd" value="<?php echo $pass?>" />
				</form>																			<!-- ENVIANDO DADOS DO USUÁRIO PARA O LOGIN SER REALIZADO -->

				<script type="text/javascript">
					document.auto_log_form.submit();
				</script>
				<!-- ###################################################################################################### -->
				<?php
				}else{

				echo '<div class="container"><br><div class="alert alert-danger" role="alert">Falha na autenticação.</div></div>';

			}

			}else{
				echo '<div class="container"><br><div class="alert alert-danger" role="alert">Este IP está bloqueado</div></div>';
			}
		}



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