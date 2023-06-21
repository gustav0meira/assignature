<?php
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

require "../../config/cdn.php";
require "../../config/leftbar.php";

// em andamento
$sqlprojectAtive = "SELECT COUNT(id) AS total FROM projects WHERE status = 'ativo'";
$resultprojectAtive = mysqli_query($conn, $sqlprojectAtive);
$rowprojectAtive = mysqli_fetch_assoc($resultprojectAtive);
$totalprojectAtive = $rowprojectAtive['total'];

// finalizados
$sqlprojectEnd = "SELECT COUNT(id) AS total FROM projects WHERE status = 'finalizado'";
$resultprojectEnd = mysqli_query($conn, $sqlprojectEnd);
$rowprojectEnd = mysqli_fetch_assoc($resultprojectEnd);
$totalprojectEnd = $rowprojectEnd['total'];

// clientes
$sqlClients = "SELECT COUNT(id) AS total FROM clients WHERE status = 'ativo'";
$resultClients = mysqli_query($conn, $sqlClients);
$rowClients = mysqli_fetch_assoc($resultClients);
$totalClients = $rowClients['total'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../assets/css/painel.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/projetos.css">
</head>
<body>
    <div class="container">
        <div class="row">
        	<div class="col-4">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i class="fa-solid fa-dollar item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Em Andamento</label><br>
                            <label class="submoduleDesc"><?php echo $totalprojectAtive ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i style="color: white !important" class="fa-solid fa-thumbs-up item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Finalizados</label><br>
                            <label class="submoduleDesc"><?php echo $totalprojectEnd ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i style="color: white !important" class="fa-solid fa-thumbs-down item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Clientes</label><br>
                            <label class="submoduleDesc"><?php echo $totalClients ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
            	<button id="btnSideAtive" class="addButt"><i class="fa-solid fa-plus fa-xs"></i>ﾠNovo Projeto</button>
            </div>
            <div class="col-12">
				<div class="module">
				    <div class="row">
						<table class="table">
						  <thead>
						    <tr>
						      <th style="padding-left: 20px;" scope="col">#</th>
						      <th scope="col">Título</th>
						      <th scope="col">Cliente</th>
						      <th scope="col">Supervisor</th>
						      <th scope="col">Prazo</th>
						      <th style="width: 130px;" scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
							<?php
							setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
							date_default_timezone_set('America/Sao_Paulo');
							$consulta = "SELECT * FROM projects WHERE status = 'ativo' ORDER BY end_date ASC LIMIT 5";
							$con = $conn->query($consulta) or die($conn->error);

							if (mysqli_num_rows($con) > 0) {
							while($dado = $con->fetch_array()) { ?>
							<?php $prazo = strtotime($dado['end_date']) - strtotime(date('Y-m-d')); $prazo = round($prazo / (60 * 60 * 24)); ?>
						    <tr>
								<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
								<td><?php echo $dado['name'] ?></td>
								<?php $clientId = $dado['client_id']; $query = "SELECT * FROM clients WHERE id = '$clientId'";
								$responseQuery = mysqli_query($conn, $query);
								while ($super = mysqli_fetch_array($responseQuery)) {$client = $super;}; ?>
								<td>
									<img class="supPP" src="../../assets/clients/<?php echo $client['pp']; ?>"> 
									<label><?php echo ucfirst($client['name']); ?></label>
								</td>
								<?php $supId = $dado['supervisor']; $query = "SELECT * FROM users WHERE id = '$supId'";
								$responseQuery = mysqli_query($conn, $query);
								while ($super = mysqli_fetch_array($responseQuery)) {$supervisor = $super;}; ?>
								<td>
									<img class="supPP" src="../../assets/pp/<?php echo $supervisor['pp']; ?>"> 
									<label><?php echo ucfirst($supervisor['username']); ?></label>
									<img class="supIcon" src="../../assets/icons/<?php echo $supervisor['job_function']; ?>.png">
								</td>
								<td><?php echo $prazo ?> dias</td>
								<td class="tdIcon">
									<?php if (!empty($dado['link'])) {
										echo '<a target="_blank" href="'.$dado["link"].'"><i class="fa-regular fa-share-from-square"></i></a>';
									} ?>
									<a href="../project-view/?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-eye"></i></a>
									<a onclick="return confirm('Tenha em mente que esta ação é irreversível!')" href="./remove.php?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-trash-can"></i></a>
								</td>
						    </tr>
							<?php } } else { echo '<center>Não há nenhum projeto cadastrado!</center>'; } ?>
						  </tbody>
						</table>
				    </div>
				</div>
            </div>
        </div>
    </div>
</body>
<div id="sidebarNewFature" class="sidebarNewFature">
	<div class="sideFinanContent">
		<form method="POST" action="./addProject.php">
			<p style="margin-top: 20px; margin-bottom: 10px !important;">📄 Novo Projeto</p>
			<label>Título:</label>
			<input required placeholder="Insira aqui o título" type="text" name="title"><br>
			<label>Data Entrega:</label>
			<input required type="date" name="date"><br>
			<label>Cliente:</label>
			<select name="client_id">
			    <?php
			    $sql = "SELECT * FROM clients WHERE status = 'ativo'";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] . ' ' . $row['surname'] ?></option>
				<?php } } else { echo "<option>Outro</option>"; } mysqli_free_result($result); ?>
				<option>Avulso</option>
			</select><br>
			<label>Supervisor:</label>
			<select name="supervisor_id">
			    <?php
			    $sql = "SELECT * FROM users WHERE status = 'ativo'";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<option value="<?php echo $row['id'] ?>">Sir <?php echo ucfirst($row['username']) ?></option>
				<?php } } else { echo "<option>Outro</option>"; } mysqli_free_result($result); ?>
			</select><br>
			<label>Link Workana:</label>
			<input type="url" name="link"><br>
			<label>Briefing:</label>
			<textarea style="height: 130px !important;" name="briefing"></textarea><br>
			<button class="save">SALVAR</button>
		</form>
	</div>
</div>
<script>
$(document).ready(function() {
  var inputValor = document.getElementById("newFatureValor");
  $(inputValor).inputmask({
    alias: "currency",
    prefix: "R$ ",
    radixPoint: ",",
    groupSeparator: ".",
    autoGroup: true,
    digits: 2,
    digitsOptional: false,
    rightAlign: false,
    unmaskAsNumber: true
  });
});
</script>
<script>
var button = document.getElementById("btnSideAtive");
var sidebar = document.getElementById("sidebarNewFature");

function abrirSidebar() {
  sidebar.classList.add("sideOpenBar");
}

function fecharSidebar(event) {
  if (event.target !== button && !sidebar.contains(event.target)) {
    sidebar.classList.remove("sideOpenBar");
  }
}

button.addEventListener("click", function(event) {
  event.stopPropagation();
  abrirSidebar();
});

document.addEventListener("click", function(event) {
  fecharSidebar(event);
});
</script>
</html>