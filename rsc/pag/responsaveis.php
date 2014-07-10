<div class="container tickets">
<h1>Responsáveis</h1>
<?php


	if(isset($_GET['idtck'])){
	$stmt = "SELECT tck_user_ticket.id_user, tck_user.id, tck_user.nome, tck_user.email, tck_user.user FROM tck_user_ticket
	JOIN tck_user ON tck_user.id = tck_user_ticket.id_user
	WHERE tck_user_ticket.id_ticket =".$_GET['idtck'];

	$stmt = mysql_query($stmt);
	if (mysql_num_rows($stmt)) {
		
	
	?>

	<table id="ticket_table" class="row-border hover stripe">
		<thead>
			<th>#</th>
			<th>Nome</th>
			<th>Email</th>
			<th>User</th>
		</thead>
		<tbody>
			<?php
			while ($rsc = mysql_fetch_array($stmt)) {
				?>

				<tr>
					<td><?php echo $rsc['id']?></td>
					<td><?php echo $rsc['nome']?></td>
					<td><?php echo $rsc['email']?></td>
					<td><?php echo $rsc['user']?></td>
				</tr>


			<?php } ?>
		</tbody>


	</table>



	<?php

	}else{
		echo '<div class="alert alert-warning" role="alert">
		  Não há usuários responsáveis por este ticket. <a href="?pag=tickets" class="alert-link">Volte à páginas de Tickets</a>
		</div>';
	}
	}else{ ?>
		<div class="alert alert-warning" role="alert">
		  Erro na listagem de usuários. <a href="?pag=tickets" class="alert-link">Volte à páginas de Tickets</a>
		</div>
  <?php	} ?>

  <a href="?pag=tickets" class="btn btn-default" style="width: 100px">Voltar</a>
  </div>