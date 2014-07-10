<?php include('rsc/system_arqs/menu.php'); ?>
<div class="container usuarios">
 	<h1>Usuários</h1>

 	<?php
 	if(isset($_SESSION['id_logged'])){
 		if(!isset($_GET['interna'])){
		$stmt = "SELECT tipo FROM tck_user WHERE id =".$_SESSION['id_logged'];
		$stmt = mysql_query($stmt);
		$rsc = mysql_fetch_array($stmt);

		if($rsc['tipo'] == '1'){
			$stmt = "SELECT * FROM tck_user WHERE tipo != 3";
			$stmt = mysql_query($stmt);
			?>
			<table id="ticket_table" class="row-border hover stripe">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Email</th>
						<th>User</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($res = mysql_fetch_array($stmt)) {

						$id    = $res['id'];
						$nome  = $res['nome'];
						$email = $res['email'];
						$user  = $res['user'];
						?>
						<tr>
							<td><?php echo $id ?></td>
							<td><?php echo $nome ?></td>
							<td><?php echo $email ?></td>
							<td><?php echo $user ?></td>
							<td>
							<form method="post" id="exclude_form_<?php echo $id ?>" action="rsc/system_arqs/actions.php">
							<a href="?pag=user_tickets&interna=<?php echo $id ?>" class="btn btn-success" style="width: 30%;">Tickets</a>
							<a href="?pag=usuarios&interna=<?php echo $id ?>" class="btn btn-warning" style="width: 30%;">Editar</a>
							<input type="hidden" name="excluir_user" value="<?php echo $id ?>">
							<input type="button" id="btn_submit_<?php echo $id ?>" value="Excluir" class="btn btn-danger" style="width: 30%;">
							</form>
							<script type="text/javascript">
							$(document).ready(function(){
								 $('#btn_submit_<?php echo $id ?>').click(function(){
							    	if (confirm('Tem certeza que deseja excluir este usuário?')) {
							   			$('#exclude_form_<?php echo $id ?>').submit();
									} 
							    })
							})
							</script>
							</td>
						</tr>


						<?php
					}

					?>
				</tbody>
			</table>

			<br><a href="?pag=usuarios&interna=-1" class="btn btn-info" style="width: 10%;">Novo Usuário</a>

			<?php

		}else{
			echo '<br><div class="alert alert-danger" role="alert">Você não tem permissão para esta funcionalidade</div>';
		}

		}else{
			if($_GET['interna'] == -1){ ?>
				<form method="post" id="userForm" action="rsc/system_arqs/actions.php">
				<input type="hidden" name="newUser" value="1">
				<div class="form-group">
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" class="form-control" required>
				</div>

				<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" class="form-control" required>
				</div>

				<div class="form-group">
				<label for="user">User</label>
				<input type="text" name="user" id="user" class="form-control" required>
				</div>

				<div class="form-group">
				<label for="newpasswd">Senha</label>
				<input type="password" name="newpasswd" id="newpasswd" class="form-control" required>
				</div>

				<div class="form-group">
				<label for="confirmPasswd">Confirme a Senha</label>
				<input type="password" name="confirmPasswd" id="confirmPasswd" class="form-control" required>
				</div>


				<?php if(isset($_GET['erroSenha'])){ ?>
				<div class="alert alert-danger" id="passwdAlert" role="alert">As senhas não batem</div>
				<?php } ?>

				<div class="form-group">
					<input type="checkbox" name="adm">Administrador
				</div>

				<div class="form-group">
				<input type="submit" class="btn btn-success" value="Cadastrar">
				</div>




			</form>
			<?php }else{
				$stmt = "SELECT * FROM tck_user WHERE id =".$_GET['interna'];
				$stmt = mysql_query($stmt);
				$res = mysql_fetch_array($stmt);
			?>

			<form method="post" action="rsc/system_arqs/actions.php">
				<input type="hidden" name="updateUser" value="<?php echo $_GET['interna'] ?>">

				<div class="form-group">
				<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" class="form-control" value="<?php echo $res['nome']?>" required>
				</div>

				<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" class="form-control" value="<?php echo $res['email']?>" required>
				</div>

				<div class="form-group">
				<label for="user">User</label>
				<input type="text" name="user" id="user" class="form-control" value="<?php echo $res['user']?>" required>
				</div>

				<div class="form-group">
				<label for="newpasswd">Senha antiga</label>
				<input type="password" name="passwd" id="passwd" class="form-control" required>
				</div>

				<div class="form-group">
				<label for="newpasswd">Nova Senha</label>
				<input type="password" name="newpasswd" id="newpasswd" class="form-control" required>
				</div>

				<div class="form-group">
				<label for="confirmPasswd">Confirme a Senha</label>
				<input type="password" name="confirmPasswd" id="confirmPasswd" class="form-control" required>
				</div>

				<?php if(isset($_GET['erroSenha']) && $_GET['erroSenha'] == 1){ ?>
				<div class="alert alert-danger" id="passwdAlert" role="alert">As senhas não batem</div>
				<?php } ?>

				<?php if(isset($_GET['erroSenha']) && $_GET['erroSenha'] == 2){ ?>
				<div class="alert alert-danger" id="passwdAlert" role="alert">Senha antiga incorreta</div>
				<?php } ?>

				<?php 
					if($res['tipo'] == 1){ ?>
					<input type="checkbox" name="adm" checked>Administrador
				<?php
					}else{ ?>
					<input type="checkbox" name="adm"> Administrador
				<?php	} ?>

				<div class="form-group">
				<input type="submit" class="btn btn-info" value="Atualizar" >
				</div>




			</form>


			<?php
			}

			?>

		<a href="?pag=usuarios" class="btn btn-default" style="width: 100px">Voltar</a>
		<?php 

		}


	}
	?>

	

</div>