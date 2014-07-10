<?php
	include('contants.php');

	session_start();
	unset($_SESSION['id_logged']);
	unset($_SESSION['id_logged_client']);

	echo "<script>window.location = 'http://".WEBROOT."';</script>";


?>