<meta charset="utf-8">
<?php
	include('connection.php'); 
	include('contants.php');
	require("phpmailer/class.phpmailer.php");

	$mail = new PHPMailer();
	$mail->setLanguage('pt');
	$from 	= "noreply@backupmanager.info";
	$fromName   = "Suporte Datasafer";

	$host 		= 'localhost';
	$port 		= 25;
	$secure		= false;

	$mail->From 	= $from;
	$mail->FromName = $fromName;
	$mail->addReplyTo($from, $fromName);
	
	$mail->isHTML(true);
	$mail->isSMTP();

	$mail->Host 		= $host;
	$mail->Port  		= $port;
	$mail->SMTPSecure	= $secure;

	$mail->CharSet 	= 'utf-8';
	$mail->WordWrap = 70;



	session_start();

	

	//LOGANDO ###################################################################################################################

	if(isset($_POST['logando'])){ 
		echo "Logando...";
		$user = $_POST['login'];
		$pass = md5($_POST['passwd']);

		$stmt = "SELECT * FROM tck_user WHERE user = '".$user."' AND passwd= '".$pass."'";
	
		$stmt = mysql_query($stmt);
		if(mysql_num_rows($stmt) > 0){
			while ($rsc = mysql_fetch_array($stmt)) {
				$_SESSION['id_logged'] = $rsc['id'];
			}
			echo "<script> window.location = 'http://".WEBROOT."?pag=home'; </script>";
		}else{
			$stmt = "SELECT * FROM tck_client WHERE user = '".$user."' AND passwd= '".$pass."'";

			$stmt = mysql_query($stmt);
				if(mysql_num_rows($stmt) > 0){
					while ($rsc = mysql_fetch_array($stmt)) {
						$_SESSION['id_logged_client'] = $rsc['id'];
					}
					echo "<script> window.location = 'http://".WEBROOT."?pag=home'; </script>";
				}else{
					echo "<script> window.location = 'http://".WEBROOT."?error=1'; </script>";
					
				}	
			
		}
	}

	//ASSUMINDO TICKET ##########################################################################################################

	if(isset($_POST['id_user']) && isset($_POST['id_ticket']) && isset($_POST['assumir'])){ 
		$id_user   = $_POST['id_user'];
		$id_ticket = $_POST['id_ticket'];

		$stmt = "INSERT INTO tck_user_ticket (id_user, id_ticket) VALUES ($id_user, $id_ticket)";
		echo $stmt;
		$stmt = mysql_query($stmt);
		if($stmt){
			$query = "UPDATE tck_ticket SET estado = 2 WHERE id =".$id_ticket;
			mysql_query($query);
		}

		$mailQuery = "SELECT nome, email FROM tck_client 
		JOIN tck_ticket ON tck_ticket.cliente = tck_client.id
		WHERE tck_ticket.id = ".$id_ticket;
		$mailQuery = mysql_query($mailQuery);
		$rsc = mysql_fetch_object($mailQuery);

		$mail->addAddress($rsc->email, $rsc->nome);

		$mail->Subject = 'Ticket Datasafer';
		$mail->Body    = 'O Ticket enviado por você ao sistema de tickets Datasafer foi assumido por um de nossos técnicos<br>
						  Acompanhe-o acessando <a href="ticket.datasafer.com.br">Este link</a> e fazendo seu login.<br><br>

						  Equipe de suporte Datasafer.<br><br>
						  (Este email é gerado automaticamente. Favor não responder.)';
		$mail->altBody = 'O Ticket enviado por você ao sistema de tickets Datasafer foi assumido por um de nossos técnicos. 
						  Acompanhe-o acessando o sistema (ticket.datasafer.com.br) e fazendo seu login. 

						  Equipe de suporte Datasafer.
						  (Este email é gerado automaticamente. Favor não responder.)';


				$envio = $mail->Send();

				if($envio){
					echo "Email enviado com sucesso";
				}else{
					echo "Erro: ".$mail->ErrorInfo;
				}


		echo "<script> window.location = 'http://".WEBROOT."?pag=tickets'; </script>";
	}

	// ADICIONANDO COMENTÁRIO ####################################################################################################

	if(isset($_POST['id_user']) && isset($_POST['id_ticket']) && isset($_POST['comentario']) && isset($_POST['coment'])){
		$id_user    = $_POST['id_user'];
		$id_ticket  = $_POST['id_ticket'];
		$comentario = $_POST['coment'];

		$id_user = str_replace('c', '', $id_user, $count);

		if($count == 0){
		$stmt = "INSERT INTO `tck_comentario`(`id_user`, `id_ticket`, `comentario`, `data`) VALUES ($id_user,$id_ticket,'$comentario', '".date("Y-m-d")."')";
		}else{
		$stmt = "INSERT INTO `tck_comentario`(`id_client`, `id_ticket`, `comentario`, `data`) VALUES ($id_user,$id_ticket,'$comentario', '".date("Y-m-d")."')";	
		}
		$stmt = mysql_query($stmt);

		$mailQuery = "SELECT nome, email FROM tck_client 
		JOIN tck_ticket ON tck_ticket.cliente = tck_client.id
		WHERE tck_ticket.id = ".$id_ticket;
		$mailQuery = mysql_query($mailQuery);
		$rsc = mysql_fetch_object($mailQuery);

		$mail->addAddress($rsc->email, $rsc->nome);

		$mail->Subject = 'Ticket Datasafer';
		$mail->Body    = 'Foi adicionado um comentário ao ticket inserido por você no <a href="localhost/DataSaferTickets">sistema de tickets da Datasafer</a>
						  Acesse o sistema para acompanhar o ticket. <br><br>
						  Equipe de suporte Datasafer.';
		$mail->altBody = 'Foi adicionado um comentário ao ticket inserido por você no sistema de tickets da Datasafer.
						  Acesse o sistema para acompanhar o ticket. 
						  Equipe de suporte Datasafer.';


				$envio = $mail->Send();

				if($envio){
					echo "Email enviado com sucesso";
				}else{
					echo "Erro: ".$mail->ErrorInfo;
				}


   


		echo "<script> window.location = 'http://".WEBROOT."?pag=tickets&interna=$id_ticket'; </script>";
	}

	// FECHANDO TICKET #########################################################################################################

	if(isset($_POST['fechandoTicket']) && isset($_POST['causa']) && isset($_POST['resolucao'])){
		$causa  = $_POST['causa'];
		$resol  = $_POST['resolucao'];
		$id_tck = $_POST['id_ticket'];

		$stmt = "UPDATE tck_ticket SET causa = '$causa', resolucao = '$resol', estado = 3 WHERE id = $id_tck";
		$stmt = mysql_query($stmt);

		$mailQuery = "SELECT nome, email FROM tck_client 
		JOIN tck_ticket ON tck_ticket.cliente = tck_client.id
		WHERE tck_ticket.id = ".$id_tck;
		$mailQuery = mysql_query($mailQuery);
		$rsc = mysql_fetch_object($mailQuery);

		$mail->addAddress($rsc->email, $rsc->nome);

		$mail->Subject = 'Ticket Datasafer';
		$mail->Body    = 'O Ticket enviado por você ao sistema de tickets Datasafer foi considerado concluído. <br><br>
						  Causa: '.$_POST['causa'].'<br><br>

						  Resolução do problema: '.$_POST['resolucao'].'<br><br>

						  Se quiser fazer alguma observação ou comentário sobre o problema: <a href="ticket.datasafer.com.br">acesse o sistema</a> e faça o login<br><br>
						  Equipe de Suporte Datasafer. <br><br>

						  (Esse email é gerado automaticamente. Favor não responder)';
		$mail->altBody = 'O Ticket enviado por você ao sistema de tickets Datasafer foi considerado concluído.

						  Causa: '.$_POST['causa'].'


						  Resolução do problema: '.$_POST['resolucao'].'

						  Se quiser fazer alguma observação ou comentário sobre o problema: <a href="ticket.datasafer.com.br">acesse o sistema</a> e faça o login

						  Equipe de Suporte Datasafer.

						  (Esse email é gerado automaticamente. Favor não responder)';


				$envio = $mail->Send();

				if($envio){
					echo "Email enviado com sucesso";
				}else{
					echo "Erro: ".$mail->ErrorInfo;
				}


		

		echo "<script> window.location = 'http://".WEBROOT."?pag=tickets&interna=$id_tck'; </script>";



	}

	// ADICIONANDO USUÁRIO ####################################################################################################

	if(isset($_POST['newUser'])){
		$nome 	= $_POST['nome'];
		$email	= $_POST['email'];
		$user 	= $_POST['user'];
		$senha	= $_POST['newpasswd'];
		$csenha = $_POST['confirmPasswd'];
		
		if(isset($_POST['adm'])){
			$tipo = 1;
		}else{
			$tipo = 2;
		}

		if(isset($_POST['newClient'])){
			$tipo = 3;
		}

		if ($senha != $csenha) {
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=-1&erroSenha=1'; </script>";

		}else{
			$stmt = "INSERT INTO `tck_user`(`nome`, `email`, `user`, `passwd`, `tipo`) VALUES ('$nome','$email','$user','".md5($senha)."',$tipo)";
			$stmt = mysql_query($stmt);
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=".mysql_insert_id()."'; </script>";
		}
	}

	// ATUALIZANDO USUÁRIO #####################################################################################################

	if(isset($_POST['updateUser'])){
		$id 	= $_POST['updateUser'];
		$nome 	= $_POST['nome'];
		$email	= $_POST['email'];
		$user 	= $_POST['user'];
		$senha  = $_POST['passwd'];
		$nsenha	= $_POST['newpasswd'];
		$csenha = $_POST['confirmPasswd'];

		if(isset($_POST['adm'])){
			$tipo = 1;
		}else{
			$tipo = 2;
		}

		$stmt = "SELECT * FROM tck_user WHERE id =".$id;
		$stmt = mysql_query($stmt);
		$res = mysql_fetch_array($stmt);
		$userSenha = $res['passwd'];

		if(md5($senha) != $userSenha){
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=$id&erroSenha=2'; </script>";
		}elseif($nsenha != $csenha){
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=$id&erroSenha=1'; </script>";
		}elseif ($nsenha == "") {
			$mantem = 1;
		}else{
			if(!isset($mantem)){
			$stmt = "UPDATE `tck_user` SET `nome`=$nome,`email`=$email,`user`=$user,`passwd`=".md5($nsenha).",`tipo`=$tipo WHERE id = $id";
			}else{
			$stmt = "UPDATE `tck_user` SET `nome`=$nome,`email`=$email,`user`=$user,`passwd`=".md5($userSenha).",`tipo`=$tipo WHERE id = $id";	
			}

			$stmt = mysql_query($stmt);
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=$id'; </script>";

		}
	}

	// EXCLUINDO USUÁRIO ###########################################################################################################

	if(isset($_POST['excluir_user'])){
		$stmt = "DELETE FROM tck_user_ticket WHERE id_user =".$_POST['excluir_user'];
		mysql_query($stmt);
		if($stmt){
			$stmt = "DELETE FROM tck_comentario WHERE id_user =".$_POST['excluir_user'];
			mysql_query($stmt);
			if($stmt){
				$stmt = "DELETE FROM tck_user WHERE id =".$_POST['excluir_user'];
				mysql_query($stmt);

				echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios'; </script>";

			}
		}
	}

	//INCLUINDO CLIENTE ###########################################################################################################

	if(isset($_POST['newClient'])){
		$nome 	= $_POST['nome'];
		$email	= $_POST['email'];
		$user 	= $_POST['user'];
		$senha	= $_POST['newpasswd'];
		$csenha = $_POST['confirmPasswd'];
		
	

		if ($senha != $csenha) {
			echo "<script> window.location = 'http://".WEBROOT."?pag=client&interna=-1&erroSenha=1'; </script>";

		}else{
			$stmt = "INSERT INTO `tck_client`(`nome`, `email`, `user`, `passwd`) VALUES ('$nome','$email','$user','".md5($senha)."')";
			$stmt = mysql_query($stmt);
			echo "<script> window.location = 'http://".WEBROOT."?pag=client&interna=".mysql_insert_id()."'; </script>";
		}
	}

	// EDITANDO CLIENTE ##########################################################################################################

	if(isset($_POST['updateClient'])){
		$id 	= $_POST['updateClient'];
		$nome 	= $_POST['nome'];
		$email	= $_POST['email'];
		$user 	= $_POST['user'];
		$senha  = $_POST['passwd'];
		$nsenha	= $_POST['newpasswd'];
		$csenha = $_POST['confirmPasswd'];


		$stmt = "SELECT * FROM tck_client WHERE id =".$id;
		$stmt = mysql_query($stmt);
		$res = mysql_fetch_array($stmt);
		$userSenha = $res['passwd'];

		if(md5($senha) != $userSenha){
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=$id&erroSenha=2'; </script>";
		}elseif($nsenha != $csenha){
			echo "<script> window.location = 'http://".WEBROOT."?pag=usuarios&interna=$id&erroSenha=1'; </script>";
		}elseif ($nsenha == "") {
			$mantem = 1;
		}else{
			if(!isset($mantem)){
			$stmt = "UPDATE `tck_client` SET `nome`=$nome,`email`=$email,`user`=$user,`passwd`=".md5($nsenha)." WHERE id = $id";
			}else{
			$stmt = "UPDATE `tck_client` SET `nome`=$nome,`email`=$email,`user`=$user,`passwd`=".md5($userSenha)." WHERE id = $id";	
			}

			$stmt = mysql_query($stmt);
			echo "<script> window.location = 'http://".WEBROOT."?pag=client&interna=$id'; </script>";

		}
	}

	// EXCLUINDO CLIENTE #################################################################################################

	if(isset($_POST['excluir_client'])){
		$id = $_POST['excluir_client'];

		$stmt = "DELETE FROM tck_ticket WHERE cliente =".$id;
		$stmt = mysql_query($stmt);
		if($stmt){
			$stmt = "DELETE FROM tck_client WHERE id =".$id;
			$stmt = mysql_query($stmt);	
			echo "<script> window.location = 'http://".WEBROOT."?pag=client'; </script>";
		}
	}

	// INSERINDO TICKET ##################################################################################################

	if(isset($_POST['newTicket'])){
		$assunto = $_POST['assunto'];
		$desc	 = $_POST['desc'];
		$cliente = $_POST['client'];

		$stmt = "INSERT INTO tck_ticket (assunto, descricao, estado, cliente) VALUES ('$assunto', '$desc',1, '$cliente')";
		$stmt = mysql_query($stmt);

		if(isset($_SESSION['id_logged'])){
		echo "<script> window.location = 'http://".WEBROOT."?pag=tickets'; </script>";
		}else{
		echo "<script> window.location = 'http://".WEBROOT."?pag=client_tickets&interna=".$_SESSION['id_logged_client']."'; </script>";	
		}
	}

	// UPLOAD DE arq ###############################################################################################

	if (isset($_POST['upload_arquivo'])) {
	
					// Pasta onde o arq vai ser salvo
				$_UP['pasta'] = 'uploads/';

				// Tamanho máximo do arq (em Bytes)
				$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

				// Array com as extensões permitidas
				$_UP['extensoes'] = array('jpg', 'png', 'gif', 'pdf');

				// Renomeia o arq? (Se true, o arq será salvo como .jpg e um nome único)
				$_UP['renomeia'] = false;

				// Array com os tipos de erros de upload do PHP
				$_UP['erros'][0] = 'Não houve erro';
				$_UP['erros'][1] = 'O arq no upload é maior do que o limite do PHP';
				$_UP['erros'][2] = 'O arq ultrapassa o limite de tamanho especifiado no HTML';
				$_UP['erros'][3] = 'O upload do arq foi feito parcialmente';
				$_UP['erros'][4] = 'Não foi feito o upload do arq';

				// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
				if ($_FILES['arq']['error'] != 0) {
				echo "Não foi possível enviar o arquivo, Verifique se escolheu o arquivo corretamente. Caso sim, Contate o programador, ou informe o problema no menu 'Relatar Bug'. <a href='http://ticket.datasafer.com.br/?pag=tickets&interna=".$_POST['id_ticket']."'>Voltar</a><br>";
				exit; // Para a execução do script
				}

				// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

				// Faz a verificação da extensão do arq
				$extensao = strtolower(end(explode('.', $_FILES['arq']['name'])));
				if (array_search($extensao, $_UP['extensoes']) === false) {
				echo "Por favor, envie arquivos com as seguintes extensões: jpg, png , gif ou pdf";
				}

				// Faz a verificação do tamanho do arq
				else if ($_UP['tamanho'] < $_FILES['arq']['size']) {
				echo "O arquivo enviado é muito grande, envie arqs de até 2Mb.";
				}

				// O arq passou em todas as verificações, hora de tentar movê-lo para a pasta
				else {
				// Primeiro verifica se deve trocar o nome do arq
				if ($_UP['renomeia'] == true) {
				// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
				$nome_final = time().'.jpg';
				} else {
				// Mantém o nome original do arq
				$nome_final = $_FILES['arq']['name'];
				}

				

				// Depois verifica se é possível mover o arq para a pasta escolhida
				if (move_uploaded_file($_FILES['arq']['tmp_name'], $_UP['pasta'] . $nome_final)) {
				// Upload efetuado com sucesso, exibe uma mensagem e um link para o arq
				$stmt = "INSERT INTO tck_arquivos (arq_name, arq_link, ticket, data) VALUES ('".$nome_final."', '"."rsc/system_arqs/uploads/" . $nome_final ."', ".$_POST['id_ticket'].", '".date('Y-m-d')."')";
				$stmt = mysql_query($stmt);

				$mailQuery = "SELECT nome, email FROM tck_client 
				JOIN tck_ticket ON tck_ticket.cliente = tck_client.id
				WHERE tck_ticket.id = ".$_POST['id_ticket'];
				$mailQuery = mysql_query($mailQuery);
				$rsc = mysql_fetch_object($mailQuery);

				$mail->addAddress($rsc->email, $rsc->nome);

				$mail->Subject = 'Ticket Datasafer';
				$mail->Body    = 'Foi adicionado um arquivo ao ticket enviado por você ao sistema de tickets Datasafer. Clique <a href="ticket.datasafer.com.br">Aqui</a> para acessar o sistema.<br>
				Equipe de Suporte Datasafer.<br>
				(Este email é gerado automaticamente. Favor não responder.)';
				$mail->altBody = 'Foi adicionado um arquivo ao ticket enviado por você ao sistema de tickets Datasafer. Acesse ticket.datasafer.com.br e faça seu login para acompanhar o andamento do ticket.
				Equipe de Suporte Datasafer.
				(Este email é gerado automaticamente. Favor não responder.)';

						$envio = $mail->Send();

						if($envio){
							echo "Email enviado com sucesso";
						}else{
							echo "Erro: ".$mail->ErrorInfo;
						}

				echo "<script> window.location = 'http://".WEBROOT."?pag=tickets&interna=".$_POST['id_ticket']."'; </script>";


				
				} else {
				// Não foi possível fazer o upload, provavelmente a pasta está incorreta
				echo "Não foi possível enviar o arquivo, Contate o programador, ou informe o problema no menu 'Relatar Bug'. <a href='ticket.datasafer.com.br/?pag=tickets&interna=".$_POST['id_ticket']."'>Voltar</a>";
				}

				}

	}





?>
