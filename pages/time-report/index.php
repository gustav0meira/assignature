<?php
$pageName = str_replace('-', ' ', ucwords(basename(__DIR__)));
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require "../../config/cdn.php";
require "../../config/leftbar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../assets/css/painel.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/projetos-view.css">
</head>
<body>
    <div class="container projectsView">
        <div class="row">
        	<div class="col-12">
        		<form <?php if($user['username'] == 'lancelot' OR $user['username'] == 'arthur'){}else{echo 'style="display: none !important;"';} ?> method="POST" action="./addTasks.php">
	        		<div style="margin-top: 20px;" class="row">
	        			<div class="col-sm">
	        				<input value="<?php echo $proId; ?>" type="hidden" name="project_id">
	        				<label style="background: #454648 !important;" class="input">Título</label>
	        				<input required type="text" name="title">
	        			</div>
	        			<div class="col-3">
	        				<label style="background: #454648 !important;" class="input">Projeto</label>
	        				<select required name="project_id">
								<?php
								$consulta = "SELECT * FROM projects WHERE status = 'ativo'";
								$con = $conn->query($consulta) or die($conn->error);
								while($dado = $con->fetch_array()) { ?>
	        					<option value="<?php echo $dado['id'] ?>"><?php echo ucfirst($dado['name']) ?></option>
								<?php } ?>
	        				</select>
	        			</div>
	        			<div class="col-2">
	        				<label style="background: #454648 !important;" class="input">Responsável</label>
	        				<select required name="responsavel">
								<?php
								$consulta = "SELECT * FROM users WHERE status = 'ativo'";
								$con = $conn->query($consulta) or die($conn->error);
								while($dado = $con->fetch_array()) { ?>
	        					<option value="<?php echo $dado['id'] ?>"><?php echo ucfirst($dado['username']) ?></option>
								<?php } ?>
	        				</select>
	        			</div>
	        			<div class="col-2">
	        				<label style="background: #454648 !important;" class="input">Prazo</label>
	        				<input type="date" name="prazo">
	        			</div>
	        			<div class="col-1">
	        				<button class="addButt"><i class="fa-regular fa-floppy-disk"></i></button>
	        			</div>
	        		</div>
        		</form>
				<?php
				$clientId = $user['id'];
				$consulta = "SELECT * FROM tasks WHERE responsavel = $clientId AND status = 0 ORDER BY prazo DESC";
				$con = $conn->query($consulta) or die($conn->error);
				while($dado = $con->fetch_array()) { ?>
        			<div style="margin-top: 20px;" class="row task">
						<div class="col-1">
							<div class="align">
								<center>
									<a onclick="return confirm('Tenha em mente que esta ação é irreversível!')" style="color: #FFFFFF30 !important;" href="./removeTask.php?id=<?php echo $dado['id'] ?>&projId=<?php echo $dado['projeto'] ?>"><i class="fa-regular fa-trash-can fa-lg"></i></a>
									<a style="color: white !important; margin-left: 10px;" href="./updateTask.php?id=<?php echo $dado['id'] ?>&projId=<?php echo $dado['projeto'] ?>&status=<?php echo $dado['status']; ?>">
										<?php $status = $dado['status']; if ($status == 0) {
											echo '<i class="fa-regular fa-square fa-lg"></i>';
										} else{
											echo '<i class="fa-solid fa-square-check fa-lg"></i>';
										} ?>
									</a>
								</center>
							</div>
						</div>
						<div class="col-8">
							<p class="align"><?php echo $dado['title'] ?></p>
						</div>
						<?php
						$projeto = $dado['projeto'];
						$query = "SELECT * FROM projects WHERE id = $projeto";
						$queryRequest = mysqli_query($conn, $query);
						while ($proj = mysqli_fetch_array($queryRequest)) { $projet = $proj; }

						$client_id = $projet['client_id'];
						$query = "SELECT * FROM clients WHERE id = $client_id";
						$queryRequest = mysqli_query($conn, $query);
						while ($cliente = mysqli_fetch_array($queryRequest)) { $client = $cliente; } ?>
						<div class="col-3">
							<div class="row align">
								<div class="col-3">
						         	<div style="background: url('../../assets/client/<?php echo $client['pp']; ?>');" class="userPP"></div>
								</div>
								<div class="col-sm">
									<?php echo $projet['name']; ?>	
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php
				$clientId = $user['id'];
				$consulta = "SELECT * FROM tasks WHERE responsavel = $clientId AND status = 1 ORDER BY prazo DESC";
				$con = $conn->query($consulta) or die($conn->error);
				while($dado = $con->fetch_array()) { ?>
        			<div style="margin-top: 20px;" class="row task">
						<div class="col-1">
							<div class="align">
								<center>
									<a onclick="return confirm('Tenha em mente que esta ação é irreversível!')" style="color: #FFFFFF30 !important;" href="./removeTask.php?id=<?php echo $dado['id'] ?>&projId=<?php echo $dado['projeto'] ?>"><i class="fa-regular fa-trash-can fa-lg"></i></a>
									<a style="color: white !important; margin-left: 10px;" href="./updateTask.php?id=<?php echo $dado['id'] ?>&projId=<?php echo $dado['projeto'] ?>&status=<?php echo $dado['status']; ?>">
										<?php $status = $dado['status']; if ($status == 0) {
											echo '<i class="fa-regular fa-square fa-lg"></i>';
										} else{
											echo '<i class="fa-solid fa-square-check fa-lg"></i>';
										} ?>
									</a>
								</center>
							</div>
						</div>
						<div class="col-8">
							<p class="align"><?php echo $dado['title'] ?></p>
						</div>
						<?php
						$projeto = $dado['projeto'];
						$query = "SELECT * FROM projects WHERE id = $projeto";
						$queryRequest = mysqli_query($conn, $query);
						while ($proj = mysqli_fetch_array($queryRequest)) { $projet = $proj; }

						$client_id = $projet['client_id'];
						$query = "SELECT * FROM clients WHERE id = $client_id";
						$queryRequest = mysqli_query($conn, $query);
						while ($cliente = mysqli_fetch_array($queryRequest)) { $client = $cliente; } ?>
						<div class="col-3">
							<div class="row align">
								<div class="col-3">
						         	<div style="background: url('../../assets/client/<?php echo $client['pp']; ?>');" class="userPP"></div>
								</div>
								<div class="col-sm">
									<?php echo $projet['name']; ?>	
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
        	</div>
        </div>
    </div>
</body>
<script>
function abrirCampoArquivo() {
  document.getElementById('newAnexo').addEventListener('change', function() {
    document.getElementById('formAnexo').submit();
  });
  document.getElementById('newAnexo').click();
}
</script>
</html>