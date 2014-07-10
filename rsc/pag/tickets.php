<?php 
	include('rsc/system_arqs/menu.php');
	if(isset($_SESSION['id_logged']) || isset($_SESSION['id_logged_client'])){

		if(isset($_GET['interna'])){
			$stmt = "SELECT tck_ticket.assunto, tck_ticket.descricao, tck_client.nome cliente, 
			tck_client.email, tck_ticket.estado, tck_ticket.causa, tck_ticket.resolucao FROM tck_ticket
			JOIN tck_client ON tck_client.id = tck_ticket.cliente WHERE tck_ticket.id =".$_GET['interna'];
			$stmt = mysql_query($stmt);
			$rsc = mysql_fetch_array($stmt);
		?>
		<div class="container">
		<div class="col-lg-6" >
		<h1>Assunto: <?php echo $rsc['assunto'] ?></h1>

		<hr>
		<h3>Descrição do problema</h3>
		<p><?php echo utf8_encode($rsc['descricao'])?></p>

		<hr>
		<h3>Cliente / E-mail</h3>
		<p><?php echo $rsc['cliente']." / ".$rsc['email']?></p>

		<hr>
		<h3>Estado do Ticket</h3>
		<p><?php 
				$estado = $rsc['estado'];
	  			$estado_stmt = "SELECT estado FROM tck_estado WHERE id = ".$estado;
	  			$estado_stmt = mysql_query($estado_stmt);
	  			$res = mysql_fetch_array($estado_stmt);
	  			echo $res['estado'];
		?></p>

		<hr>
		<form method="post" action="rsc/system_arqs/actions.php">
		<input type="hidden" name="fechandoTicket" value="1">
		<input type="hidden" name="id_ticket" value="<?php echo $_GET['interna'] ?>">
		<h3>Causa</h3>
		<textarea class="form-control" name="causa" style="height: 120px;" required <?php if(isset($_SESSION['id_logged_client'])){echo "disabled";} ?>><?php echo $rsc['causa']?></textarea>

		<hr>
		<h3>Resolução do problema</h3>
		<textarea class="form-control" name="resolucao" style="height: 120px;" required <?php if(isset($_SESSION['id_logged_client'])){echo "disabled";} ?>><?php echo $rsc['resolucao']?></textarea>

		<hr>
		<input type="submit" value="<?php if($estado == 3){echo "Atualizar";}else{echo "Fechar";}?> Ticket" class="btn btn-success" <?php if(isset($_SESSION['id_logged_client'])){echo "disabled";} ?>>
		
				<?php if(isset($_SESSION['id_logged'])){ ?>
					<a href="?pag=tickets" class="btn btn-default">Voltar</a>
					<?php }elseif(isset($_SESSION['id_logged_client'])){ ?>
					<a href="?pag=client_tickets&interna=<?php echo $_SESSION['id_logged_client'] ?>" class="btn btn-default">Voltar</a>
					<?php } ?>

		</form>




		</div>
		<div class="col-lg-6">
		<div class="col-lg-12">
			<h1>Comentários do Ticket</h1>
			<form method="post" action="rsc/system_arqs/actions.php">
				<div class="form-group">
					<?php if(isset($_SESSION['id_logged'])){ ?>
					<input type="hidden" name="id_user" value="<?php echo $_SESSION['id_logged']?>">
					<?php }elseif(isset($_SESSION['id_logged_client'])){ ?>
					<input type="hidden" name="id_user" value="<?php echo 'c'.$_SESSION['id_logged_client']?>">
					<?php } ?>
					<input type="hidden" name="id_ticket" value="<?php echo $_GET['interna']?>">
					<input type="hidden" name="comentario" value="1">
					<label for="coment">Comentário</label>
					<textarea name="coment" id="coment" placeholder="Escreva seu comentário" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" value="Enviar Comentário" class="btn btn-default">
				</div>
			</form>
			<hr>
			<div class="coment_delimiter" style="height: 300px; overflow: auto;">
			<?php 
			 $stmt = "SELECT tck_comentario.comentario, tck_comentario.data, tck_comentario.id_user, tck_comentario.id_client FROM tck_comentario
			 WHERE id_ticket =".$_GET['interna']." ORDER BY tck_comentario.id DESC";
			 $stmt = mysql_query($stmt);
			 while ($res = mysql_fetch_array($stmt)) {
			 	
			 	if(isset($res['id_user'])){
			 	?>
			 	<div class="alert alert-info" role="alert">
			 		<h5><?php echo "(".date("d/m/Y", strtotime($res['data'])).") Datasafer Disse:"; ?></h5>
			 		<p><?php echo $res['comentario'] ?></p>
			 	</div>
			 <?php
			 }else{ ?>
			 	<div class="alert alert-success" role="alert">
			 		<h5><?php echo "(".date("d/m/Y", strtotime($res['data'])).") Cliente Disse:"; ?></h5>
			 		<p><?php echo $res['comentario'] ?></p>
			 	</div>


			 <?php }} ?>
			
			</div>
		</div>
			<div class="col-lg-12">
			<h1> Arquivos do Ticket</h1>
			<div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			         Upload de arquivo
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in">
			      <div class="panel-body">
			        <form method="post" action="rsc/system_arqs/actions.php" enctype= "multipart/form-data">
			        <input type="hidden" name="id_ticket" value="<?php echo $_GET['interna'] ?>">
					<input type="hidden" name="upload_arquivo" value="1">
					<div class="form-group">
                       <label for="arq">Arquivo <small>Máximo de 2MB</small>:</label>
                       <input type="file" name="arq" id="arq">
                       <input type="submit" value="Enviar Arquivo" class="btn btn-success" style="width: 130px; margin-top: 30px;">
					</div>
					
				</form>
			      </div>
			    </div>
			  </div>
				
				

			</div>
		</div>




		</div>

			<?php

		}else{

		$stmt = "SELECT * FROM tck_ticket ORDER BY id DESC";
		$stmt = mysql_query($stmt);	
?>

<div class="container tickets">
<h1>Tickets</h1>
<table id="ticket_table" class="row-border hover stripe">
	<thead>
		<tr>
			<th>#</th>
			<th>Assunto</th>
			<th>Descrição</th>
			<th>Cliente</th>
			<th>Estado Atual</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
	<?php
	  	while ($rsc = mysql_fetch_array($stmt)) {
	  		$id 		= $rsc['id'];
	  		$assunto    = $rsc['assunto'];
	  		$descricao  = $rsc['descricao'];
	  		$cliente    = $rsc['cliente'];
	  		$estado 	= $rsc['estado'];
	  	?>
	  	<tr>
	  		<td><?php echo $id?></td>
	  		<td><?php echo $assunto ?></td>
	  		<td><?php echo utf8_encode($descricao)?></td>
	  		<td><?php 
	  		$query = "SELECT nome FROM tck_client WHERE id =".$cliente;
	  		$query = mysql_query($query);
	  		$res = mysql_fetch_array($query);
	  		echo $res['nome'];

	  		?></td>
	  		<td>
	  			<?php 
	  			$estado_stmt = "SELECT estado FROM tck_estado WHERE id = ".$estado;
	  			$estado_stmt = mysql_query($estado_stmt);
	  			$res = mysql_fetch_array($estado_stmt);
	  			echo $res['estado'];

	  			?>
	  		</td>
	  		<td>
	  		<?php 
	  			$query = "SELECT * FROM tck_user_ticket WHERE id_user = ".$_SESSION['id_logged']." AND id_ticket =".$id;
	  			$query = mysql_query($query);
	  			if(mysql_num_rows($query) == 0 && $estado != 3){
	  		?>
	  		<form method="post" action="rsc/system_arqs/actions.php">
	  			<input type="hidden" name="assumir" value="1">
	  			<input type="hidden" name="id_user" value=<?php echo "'".$_SESSION['id_logged']."'"?>>
	  			<input type="hidden" name="id_ticket" value=<?php echo "'".$id."'"?>>
	  			<input type="submit" class="btn btn-info pull-left" value="Assumir Ticket">
	  			<a href="?pag=responsaveis&idtck=<?php echo $id?>" class="btn btn-default pull-left"> Ver responsáveis </a>
	  		</form>
	  		<?php }else{ ?>

	  			<a href="?pag=tickets&interna=<?php echo $id ?>" class="btn btn-success"><?php if($estado == 2){ echo "Responder";}else{ echo "Ver";} ?> Ticket</a>
	  			<a href="?pag=responsaveis&idtck=<?php echo $id?>" class="btn btn-default pull-left"> Ver responsáveis </a>
	  		<?php } ?>
	  			
	  		
	  		</td>

	  	</tr>

	  	<?php
	  	}
		?>
	</tbody>


</table>
	<a href="?pag=newTicket" class="btn btn-info" style="width: 100px;">Novo Ticket</a>
</div>
<?php }}else{
	?>
			<a data-toggle="modal" data-target="#myModal">
				Login
			</a>
	<?php
}
?>
