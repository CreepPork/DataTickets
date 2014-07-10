<?php
	include('rsc/system_arqs/menu.php');
	if(isset($_GET['interna'])){
		$stmt = "SELECT nome FROM tck_user WHERE id =".$_GET['interna'];
		$stmt = mysql_query($stmt);
		$res = mysql_fetch_array($stmt);
	?>

		<div class="container usuarios">
			<h1> Tickets assumidos por <?php echo $res['nome']?></h1>

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
			$stmt = "SELECT tck_user_ticket.id_user, tck_ticket.id ,tck_ticket.assunto, tck_ticket.descricao, tck_estado.estado FROM tck_user_ticket
			JOIN tck_ticket ON tck_ticket.id = tck_user_ticket.id_ticket
			JOIN tck_estado ON tck_estado.id = tck_ticket.estado
			WHERE tck_user_ticket.id_user =".$_GET['interna'];
			$stmt = mysql_query($stmt);
			while ($rsc = mysql_fetch_array($stmt)) {
				$id_ticket 	= $rsc['id'];
				$assunto 	= $rsc['assunto'];
				$descricao 	= $rsc['descricao'];
				$estado 	= $rsc['estado'];

				?>
				<tr>
					<td><?php echo $id_ticket ?></td>
					<td><?php echo utf8_encode($assunto) ?></td>
					<td><?php echo utf8_encode($descricao) ?></td>
					<td><?php echo utf8_encode($estado) ?></td>
					<td><a href="?pag=tickets&interna=<?php echo $id_ticket ?>" class="btn btn-info">Acessar Ticket</a></td>
				</tr>

				<?php
			}
		?>

		</tbody>
		</table>

		<a href="?pag=usuarios" class="btn btn-default" style="width: 100px;">Voltar</a>
		</div>



	<?php
	}else{
		echo '<div class="alert alert-danger" id="passwdAlert" role="alert">Erro ao encontrar usuário</div>';
	}

?>