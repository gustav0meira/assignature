<?php
session_start();
$pageName = str_replace('-', ' ', ucwords(basename(__DIR__)));
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

require "../../config/cdn.php";
require "../../config/leftbar.php";

// Consulta para obter o total de receita
$sqlReceita = "SELECT SUM(bank_amount) AS total_receita FROM bank_accounts WHERE status = 'ativo'";
$resultReceita = mysqli_query($conn, $sqlReceita);
$rowReceita = mysqli_fetch_assoc($resultReceita);
$totalReceita = $rowReceita['total_receita'];

// Consulta para obter o número de projetos ativos
$sqlProjetos = "SELECT COUNT(*) AS total_projetos FROM projects WHERE status = 'ativo'";
$resultProjetos = mysqli_query($conn, $sqlProjetos);
$rowProjetos = mysqli_fetch_assoc($resultProjetos);
$totalProjetos = $rowProjetos['total_projetos'];

// Consulta para obter o número de clientes ativos
$sqlClientes = "SELECT COUNT(*) AS total_clientes FROM clients WHERE status = 'ativo'";
$resultClientes = mysqli_query($conn, $sqlClientes);
$rowClientes = mysqli_fetch_assoc($resultClientes);
$totalClientes = $rowClientes['total_clientes'];

// Consulta para obter o total de horas trabalhadas em todos os projetos
$sqlTimeReport = "SELECT SUM(hours) AS total_horas FROM time_report";
$resultTimeReport = mysqli_query($conn, $sqlTimeReport);
$rowTimeReport = mysqli_fetch_assoc($resultTimeReport);
$totalHoras = $valorFormatado = str_replace('.', ':', number_format($rowTimeReport['total_horas'], 2));

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../assets/css/painel.css">
</head>
<body>
    <div class="container">
        <div class="row">
        	<?php $username = $user['username'];
			if ($username == 'lancelot' OR $username == 'arthur') {
				echo '
				 <div class="col-sm">
				    <div class="module">
				        <div class="row">
				            <div class="col-3">
				                <i class="fa-solid fa-dollar item-module align"></i>
				            </div>
				            <div class="col-sm">
				                <label class="submoduleTitle">Receita</label><br>
				                <label class="submoduleDesc">R$ ' . number_format($totalReceita, 2, ',', '.') . '</label>
				            </div>
				        </div>
				    </div>
				</div>
				';
        	} ?>
            <div class="col-sm">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i class="fa-solid fa-file item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Projetos</label><br>
                            <label class="submoduleDesc"><?php echo $totalProjetos; ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i class="fa-solid fa-user item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Clientes</label><br>
                            <label class="submoduleDesc"><?php echo $totalClientes; ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i class="fa-solid fa-clock item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Time Report</label><br>
                            <label class="submoduleDesc"><?php echo $totalHoras; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <h1 class="moduleTitle">#tasks</h1>
                <div class="module">
                	<?php
					$consulta = "SELECT * FROM tasks WHERE responsavel = $userId AND status = 0 LIMIT 5";
					$con = $conn->query($consulta) or die($conn->error);
					while($dado = $con->fetch_array()) { ?>
	        		<div style="margin-bottom: 15px; margin-top: 15px; padding-left: 10px;" class="row task">
						<div class="col-1">
							<div class="align">
								<a style="color: white !important; margin-right: 10px; text-decoration: none" href="./updateTask.php?id=<?php echo $dado['id'] ?>&projId=<?php echo $dado['projeto'] ?>&status=<?php echo $dado['status']; ?>">
									<?php $status = $dado['status']; if ($status == 0) {
										echo '<i class="fa-regular fa-square fa-lg"></i>';
									} else{
										echo '<i class="fa-solid fa-square-check fa-lg"></i>';
									} ?>
								</a>
							</div>
						</div>
						<?php
						$projeto = $dado['projeto'];
						$query = "SELECT * FROM projects WHERE id = $projeto";
						$queryRequest = mysqli_query($conn, $query);
						while ($proj = mysqli_fetch_array($queryRequest)) { $projeto = $proj; } ?>
						<div class="col-8">
							<p class="align"><?php echo $dado['title'] ?> <label style="color: #FFFFFF30; font-weight: 200; font-size: 0.6rem;"> - <?php echo $projeto['name'] ?></label></p>
						</div>
						<div class="col-3">
							<div class="align">
								<input disabled class="prazoTasks" type="date" value="<?php echo $dado['prazo'] ?>" name="date">
							</div>
						</div>
					</div>
					<?php } ?>
                </div>

                <h1 class="moduleTitle">#clientes</h1>
				<div class="module">
				    <div class="row">
						<table class="table">
						  <thead>
						    <tr>
						      <th style="padding-left: 20px;" scope="col">#</th>
						      <th scope="col">Nome</th>
						      <th scope="col">E-mail</th>
						      <th scope="col">Supervisor</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
							<?php
							setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
							date_default_timezone_set('America/Sao_Paulo');
							$consulta = "SELECT * FROM clients WHERE status = 'ativo' LIMIT 5";
							$con = $conn->query($consulta) or die($conn->error);

							if (mysqli_num_rows($con) > 0) {
							while($dado = $con->fetch_array()) { ?>
						    <tr>
								<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
								<td><?php echo $dado['name'] . ' ' . $dado['surname'] ?></td>
								<td><?php echo $dado['email'] ?></td>
								<?php $supId = $dado['id_supervisor']; $query = "SELECT * FROM users WHERE id = '$supId'";
								$responseQuery = mysqli_query($conn, $query);
								while ($super = mysqli_fetch_array($responseQuery)) {$supervisor = $super;}; ?>
								<td>
									<img class="supPP" src="../../assets/pp/<?php echo $supervisor['pp']; ?>"> 
									<label><?php echo ucfirst($supervisor['username']); ?></label>
									<img class="supIcon" src="../../assets/icons/<?php echo $supervisor['job_function']; ?>.png">
								</td>
								<td><a style="color: #FFFFFF40;" href="../client-view/?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-eye"></i></a></td>
						    </tr>
							<?php } } else { echo '<center>Não há nenhum projeto cadastrado!</center>'; } ?>
						  </tbody>
						</table>
				    </div>
				</div>
                <h1 style="margin-top: 30px !important;" class="moduleTitle">#projetos</h1>
				<div class="module">
				    <div class="row">
						<table class="table">
						  <thead>
						    <tr>
						      <th style="padding-left: 20px;" scope="col">#</th>
						      <th scope="col">Título</th>
						      <th scope="col">Briefing</th>
						      <th scope="col">Prazo</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
							<?php
							setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
							date_default_timezone_set('America/Sao_Paulo');
							$consulta = "SELECT * FROM projects WHERE status = 'ativo' LIMIT 5";
							$con = $conn->query($consulta) or die($conn->error);

							if (mysqli_num_rows($con) > 0) {
							while($dado = $con->fetch_array()) { ?>
							<?php $prazo = strtotime($dado['end_date']) - strtotime(date('Y-m-d')); $prazo = round($prazo / (60 * 60 * 24)); ?>
						    <tr>
								<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
								<td><?php echo $dado['name'] ?></td>
								<td><?php echo substr($dado['description'], 0, 30) ?>...</td>
								<td><?php echo $prazo ?> dias</td>
								<td><a style="color: #FFFFFF30;" href="../project-view/?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-eye"></i></a></td>
						    </tr>
							<?php } } else { echo '<center>Não há nenhum projeto cadastrado!</center>'; } ?>
						  </tbody>
						</table>
				    </div>
				</div>
            </div>
            <div style="padding-left: 30px !important;" class="col-4">
                <h1 class="moduleTitle">#contas</h1>
			    <?php
			    $sql = "SELECT * FROM bank_accounts WHERE status = 'ativo'";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<div style="padding: 0px !important; margin-bottom: 15px !important;" class="module"><div class="row"><div class="col-3">
				<div style="background: url('<?php echo $row['bank_pp']; ?>');" class="userPP"></div></div>
				<div class="col-sm"><div class="align">
				<label class="userDesc"><?php echo $row['bank_name']; ?></label><br>
				<label class="userTitle"><?php echo 'R$ ' . number_format($row['bank_amount'], 2, ',', '.'); ?></label>
				</div></div></div></div>
				<?php } } else { echo "Nenhuma conta encontrada."; } mysqli_free_result($result); ?>

                <h1 style="margin-top: 30px;" class="moduleTitle">#usuarios-online</h1>
			    <?php
			    $sql = "SELECT * FROM users WHERE status != 'arquivado' AND logged = 1";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
				$id = $row['id'];
				$username = ucfirst($row['username']);
				$name = $row['name'];
				$surname = $row['surname'];
				$job_function = $row['job_function'];
				$profilePicture = $row['pp'];
				$last_login = date('H:i', strtotime($row['last_login'])); ?>
				<a style="color: white;" href="../user-view/?id=<?php echo $id ?>">
				<div style="padding: 0px !important; margin-bottom: 15px !important;" class="module"><div class="row"><div class="col-3">
				<div style="background: url('../../assets/pp/<?php echo $profilePicture; ?>');" class="userPP"></div></div>
				<div class="col-sm"><div class="align">
				<label class="userTitle">Sir <?php echo $username; ?> <img class="co" src="../../assets/icons/<?php echo $job_function; ?>.png"></label><br>
				<label class="userDesc"><?php echo $name . ' ' . $surname . ' | ' . $last_login; ?></label>
				</div></div></div></div>
				</a>
				<?php } } else { echo "Nenhum usuário encontrado."; } mysqli_free_result($result); ?>
            </div>
        </div>
    </div>
</body>
</html>