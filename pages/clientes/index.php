<?php
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

require "../../config/masks.php";
require "../../config/cdn.php";
require "../../config/leftbar.php";

// clientes
$sqlClients = "SELECT COUNT(id) AS total FROM clients WHERE status = 'ativo'";
$resultClients = mysqli_query($conn, $sqlClients);
$rowClients = mysqli_fetch_assoc($resultClients);
$totalClients = $rowClients['total'];

// clientes
$sqlClientsArquivados = "SELECT COUNT(id) AS total FROM clients WHERE status = 'arquivado'";
$resultClientsArquivados = mysqli_query($conn, $sqlClientsArquivados);
$rowClientsArquivados = mysqli_fetch_assoc($resultClientsArquivados);
$totalClientsArquivados = $rowClientsArquivados['total'];

// clientes
$sqlClientsEsclusive = "SELECT COUNT(id) AS total FROM clients WHERE plan = 'exclusive.png' AND status != 'arquivado'";
$resultClientsEsclusive = mysqli_query($conn, $sqlClientsEsclusive);
$rowClientsEsclusive = mysqli_fetch_assoc($resultClientsEsclusive);
$totalClientsEsclusive = $rowClientsEsclusive['total'];

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
                            <i class="fa-solid fa-user item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Ativos</label><br>
                            <label class="submoduleDesc"><?php echo $totalClients ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i style="color: white !important" class="fa-solid fa-box-archive item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Arquivados</label><br>
                            <label class="submoduleDesc"><?php echo $totalClientsArquivados ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="module">
                    <div class="row">
                        <div class="col-3">
                            <i style="color: white !important" class="fa-solid fa-star item-module align"></i>
                        </div>
                        <div class="col-sm">
                            <label class="submoduleTitle">Exclusivos</label><br>
                            <label class="submoduleDesc"><?php echo $totalClientsEsclusive ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
            	<button id="btnSideAtive" class="addButt"><i class="fa-solid fa-plus fa-xs"></i>ﾠNovo Cliente</button>
            </div>
            <div class="col-12">
				<div class="module">
				    <div class="row">
						<table class="table">
						  <thead>
						    <tr>
						      <th style="padding-left: 20px;" scope="col">#</th>
						      <th scope="col"></th>
						      <th scope="col">Nome</th>
						      <th scope="col">E-mail</th>
						      <th scope="col">Telefone</th>
						      <th scope="col">Supervisor</th>
						      <th style="width: 130px;" scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
							<?php
							setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
							date_default_timezone_set('America/Sao_Paulo');
							$consulta = "SELECT * FROM clients WHERE status = 'ativo' ORDER BY id DESC LIMIT 15";
							$con = $conn->query($consulta) or die($conn->error);

							if (mysqli_num_rows($con) > 0) {
							while($dado = $con->fetch_array()) { ?>
						    <tr>
								<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
								<td><img width="20px" src="../../assets/icons/<?php echo $dado['plan'] ?>"></td>
								<td><?php echo $dado['name'] . ' ' . $dado['surname'] ?></td>
								<td><?php echo $dado['email'] ?></td>
								<td><?php echo $dado['phone'] ?></td>
								<?php $supId = $dado['id_supervisor']; $query = "SELECT * FROM users WHERE id = '$supId'";
								$responseQuery = mysqli_query($conn, $query);
								while ($super = mysqli_fetch_array($responseQuery)) {$supervisor = $super;}; ?>
								<td>
									<img class="supPP" src="../../assets/pp/<?php echo $supervisor['pp']; ?>"> 
									<label><?php echo ucfirst($supervisor['username']); ?></label>
									<img class="supIcon" src="../../assets/icons/<?php echo $supervisor['job_function']; ?>.png">
								</td>
								<td class="tdIcon">
									<?php if (!empty($dado['link'])) {
										echo '<a target="_blank" href="'.$dado["link"].'"><i class="fa-regular fa-share-from-square"></i></a>';
									} ?>
									<a href="../client-view/?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-eye"></i></a>
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
		<form method="POST" action="./addClient.php">
			<p style="margin-top: 20px; margin-bottom: 10px !important;">📄 Novo Projeto</p>
			<label>Nome:</label>
			<input required placeholder="Insira aqui o nome" type="text" name="name"><br>
			<label>Sobrenome:</label>
			<input required placeholder="Insira aqui o sobrenome" type="text" name="surname"><br>
			<label>E-mail:</label>
			<input required placeholder="Insira aqui o e-mail" type="email" name="email"><br>
			<label>Telefone: (Formato: 99 9 9999 9999)</label>
			<input required placeholder="Insira aqui o telefone" type="tel" name="phone"><br>
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
			<label>Observações:</label>
			<textarea style="height: 130px !important;" name="obs"></textarea><br>
			<button class="save">SALVAR</button>
		</form>
	</div>
</div>
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