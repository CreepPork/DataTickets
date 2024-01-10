
<?php
include('rsc/system_arqs/connection.php'); // FIXME: Path was wrong
conecta(2); // FIXME: Added so that proper auth would be conducted
	

	if(isset($_SESSION['id_logged'])){
		$stmt = "SELECT tipo FROM tck_user WHERE id =".$_SESSION['id_logged'];
		$stmt = mysql_query($stmt);
		$rsc = mysql_fetch_array($stmt);

		if($rsc['tipo'] == '1'){
			include('rsc/system_arqs/adm_menu.php');
		}else{
			include('rsc/system_arqs/user_menu.php');
		}
		
			
		

	}elseif(isset($_SESSION['id_logged_client'])){
		include('rsc/system_arqs/client_menu.php');
	}else{
		echo '<br><div class="alert alert-danger" role="alert">Faça o login para utilizar o sistema</div>';
	}
?>
