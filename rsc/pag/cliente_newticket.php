<?php include('rsc/system_arqs/menu.php'); ?>
<div class="container usuario">
<h1>Novo Ticket</h1>
	<form method="post" action="rsc/system_arqs/actions.php">
	<input type="hidden" name="newTicket" value="1">
	<input type="hidden" name="client" value="<?php echo $_SESSION['id_logged_client']?>">

	<div class="form-group">
	<label for="assunto">Assunto</label>
	<input type="text" name="assunto" id="assunto" class="form-control"> 
	</div>

	<div class="form-group">
	<label for="desc">Descrição</label>
	<textarea name="desc" id="desc" class="form-control"></textarea>
	</div>

	<div class="form-group">
	<input type="submit" value="Cadastrar" class="btn btn-success" style="width: 100px;">
	</div>

		
	</form>
</div>