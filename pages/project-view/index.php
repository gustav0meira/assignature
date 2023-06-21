<?php
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require "../../config/cdn.php";
require "../../config/leftbar.php";

$proId = $_REQUEST['id'];
$query = "SELECT * FROM projects WHERE id = '$proId'";
$queryRequest = mysqli_query($conn, $query);
while ($projects = mysqli_fetch_array($queryRequest)) { $project = $projects; }

$clientId = $project['client_id'];
$query = "SELECT * FROM clients WHERE id = '$clientId'";
$queryRequest = mysqli_query($conn, $query);
while ($clients = mysqli_fetch_array($queryRequest)) { $client = $clients; }

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
        	<div class="col-3">
        		<h1 style="margin-top: 0px;" class="moduleTitle">#cliente</h1>

				<?php
				$sql = "SELECT * FROM clients WHERE id = $clientId";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {
				$username = ucfirst($row['name']);
				$name = $row['name'];
				$surname = $row['surname'];
				$profilePicture = $row['pp']; ?>
				<div style="padding: 0px !important; margin-bottom: 15px !important;" class="module">
				   <div class="row">
				      <div class="col-4">
				         <div style="background: url('../../assets/pp/<?php echo $profilePicture; ?>');" class="userPP"></div>
				      </div>
				      <div class="col-sm">
				         <div class="align">
				            <label class="userTitle"><?php echo $username; ?></label><br>
				            <label class="userDesc"><?php echo $surname; ?></label>
				         </div>
				      </div>
				   </div>
				</div>
				<?php } ?>

				<h1 style="margin-top: 30px;" class="moduleTitle">#supervisor</h1>
				<?php 
				$supervisor = $project['supervisor'];
				$sql = "SELECT * FROM users WHERE id = $supervisor";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {
				$username = ucfirst($row['username']);
				$name = $row['name'];
				$surname = $row['surname'];
				$job_function = $row['job_function'];
				$profilePicture = $row['pp'];
				$last_login = date('H:i', strtotime($row['last_login'])); ?>
				<div style="padding: 0px !important; margin-bottom: 15px !important;" class="module">
				   <div class="row">
				      <div class="col-4">
				         <div style="background: url('../../assets/pp/<?php echo $profilePicture; ?>');" class="userPP"></div>
				      </div>
				      <div class="col-sm">
				         <div class="align">
				            <label class="userTitle">Sir <?php echo $username; ?> <img class="co" src="../../assets/icons/<?php echo $job_function; ?>.png"></label><br>
				            <label class="userDesc"><?php echo $name . ' ' . $surname . ' | ' . $last_login; ?></label>
				         </div>
				      </div>
				   </div>
				</div>
				<?php } ?>

				<h1 style="margin-top: 30px;" class="moduleTitle">#observações</h1>
				<form method="POST" action="./updateObs.php">
					<textarea name="obs" style="height: 230px; background: #56585a;"><?php echo $project['obs'] ?></textarea>
					<input type="hidden" value="<?php echo $project['id'] ?>" name="id">
					<button class="send">ATUALIZAR</button>
				</form>
        	</div>
        	<div class="col-9">
        		<h1 style="margin-top: 0px;" class="moduleTitle">#projeto</h1>
        		<form id="project" method="POST" action="updateProject.php">
				<input value="<?php echo $project['id'] ?>" type="hidden" name="id">
	        		<div class="module">
	        			<div class="row">
	        				<div class="col-10">
	        					<label class="input">Título</label>
	        					<input value="<?php echo $project['name'] ?>" type="text" name="title">
	        				</div>
	        				<div class="col-1">
	        					<a target="_blank" href="<?php echo $project['link'] ?>"><button class="addButt"><i class="fa-solid fa-up-right-from-square"></i></button></a>
	        				</div>
	        				<div class="col-1">
	        					<button form="project" class="addButt"><i class="fa-regular fa-floppy-disk"></i></button>
	        				</div>
	        				<div class="col-12">
	        					<label class="input">Briefing</label>
	        					<textarea name="description"><?php echo $project['description'] ?></textarea>
	        				</div>
	        			</div>
	        		</div>
        		</form>
        		<form method="POST" action="./addTask.php">
	        		<div style="margin-top: 20px;" class="row">
	        			<div class="col-8">
	        				<input value="<?php echo $proId; ?>" type="hidden" name="project_id">
	        				<label style="background: #454648 !important;" class="input">Título</label>
	        				<input required type="text" name="title">
	        			</div>
	        			<div class="col-3">
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
	        			<div class="col-1">
	        				<button class="addButt"><i class="fa-regular fa-floppy-disk"></i></button>
	        			</div>
	        		</div>
        		</form>
				<?php
				$consulta = "SELECT * FROM tasks WHERE projeto = $proId";
				$con = $conn->query($consulta) or die($conn->error);
				while($dado = $con->fetch_array()) { ?>
        		<div style="margin-top: 20px;" class="row task">
					<div class="col-2">
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
					<div class="col-6">
						<p class="align"><?php echo $dado['title'] ?></p>
					</div>
					<?php
					$respoId = $dado['responsavel'];
					$query = "SELECT * FROM users WHERE id = $respoId";
					$queryRequest = mysqli_query($conn, $query);
					while ($resp = mysqli_fetch_array($queryRequest)) { $respo = $resp; } ?>
					<div class="col-4">
					   <div class="row align">
					      <div class="col-3">
					         <div style="background: url('../../assets/pp/<?php echo $respo['pp']; ?>');" class="userPP"></div>
					      </div>
					      <div class="col-sm">
					         <div class="align">
					            <label class="userTitle">Sir <?php echo $respo['username']; ?> <img class="co" src="../../assets/icons/<?php echo $respo['job_function']; ?>.png"></label><br>
					            <label class="userDesc"><?php echo $respo['name'] . ' ' . $respo['surname'] . ' | ' . date('H:i', strtotime($respo['last_login'])); ?></label>
					         </div>
					      </div>
					   </div>
					</div>
				</div>
				<?php } ?>
        	</div>
        </div>
    </div>
</body>
</html>