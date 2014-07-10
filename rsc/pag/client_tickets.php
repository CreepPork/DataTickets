<?php
	include('rsc/system_arqs/menu.php');
	if(isset($_GET['interna'])){
		$stmt = "SELECT nome FROM tck_client WHERE id =".$_GET['interna'];
		$stmt = mysql_query($stmt);
		$res = mysql_fetch_array($stmt);
	?>

		<div class="container usuarios">
			<h1> Tickets enviados por <?php echo $res['nome']?></h1>

			<table id="ticket_table">
			<thead>
				<tr>
					<th>#</th>
					<th>Assunto</th>
					<th>Descricao</th>
					<th>Estado</th>
					<th>Acessar Ticket</th>
				</tr>
			</thead>
			<tbody>

		<?php
			$stmt = "SELECT * FROM tck_ticket WHERE cliente =".$_GET['interna'];
			$stmt = mysql_query($stmt);
			while ($rsc = mysql_fetch_array($stmt)) {
				$id_ticket 	= $rsc['id'];
				$assunto 	= $rsc['assunto'];
				$descricao 	= $rsc['descricao'];
				$estado 	= $rsc['estado'];

				?>
				<tr>
					<td><?php echo $id_ticket ?></td>
					<td><?php echo $assunto ?></td>
					<td><?php echo $descricao ?></td>
					<td><?php 
					$query = "SELECT estado FROM tck_estado WHERE id =".$estado;
					$query = mysql_query($query);
					$res = mysql_fetch_array($query);
					echo $res['estado'];
					 ?></td>
					<td><a href="?pag=tickets&interna=<?php echo $id_ticket ?>" class="btn btn-info">Acessar Ticket</a></td>
				</tr>

				<?php
			}
		?>

		</tbody>
		</table>

		<a href="?pag=client" class="btn btn-default" style="width: 100px;">Voltar</a>
		</div>



	<?php
	}else{
		echo '<div class="alert alert-danger" id="passwdAlert" role="alert">Erro ao encontrar Cliente</div>';
	}

?>