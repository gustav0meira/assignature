<?php
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

require "../../config/cdn.php";
require "../../config/leftbar.php";

error_reporting(0);

// Consulta para obter o total de saldo
$sqlReceita = "SELECT SUM(bank_amount) AS total_saldo FROM bank_accounts WHERE status = 'ativo'";
$resultReceita = mysqli_query($conn, $sqlReceita);
$rowReceita = mysqli_fetch_assoc($resultReceita);
$saldo = $rowReceita['total_saldo'];

// Consulta para obter o total de receita
$sqlReceita = "SELECT SUM(amount) AS total_receita FROM accounts_receivable WHERE status != 'arquivado' AND type = 'receita'";
$resultReceita = mysqli_query($conn, $sqlReceita);
$rowReceita = mysqli_fetch_assoc($resultReceita);
$totalReceita = $rowReceita['total_receita'];

// Consulta para obter o total de despesa
$sqldespesa = "SELECT SUM(amount) AS total_despesa FROM accounts_receivable WHERE status != 'arquivado' AND type = 'despesa'";
$resultdespesa = mysqli_query($conn, $sqldespesa);
$rowdespesa = mysqli_fetch_assoc($resultdespesa);
$totaldespesa = $rowdespesa['total_despesa'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../assets/css/painel.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/financeiro.css">
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
                            <label class="submoduleTitle">Saldo</label><br>
                            <label class="submoduleDesc"><?php echo 'R$ ' . number_format($saldo, 2, ',', '.'); ?></label>
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
                            <label class="submoduleTitle">Receitas</label><br>
                            <label class="submoduleDesc"><?php echo 'R$ ' . number_format($totalReceita, 2, ',', '.'); ?></label>
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
                            <label class="submoduleTitle">Despesas</label><br>
                            <label class="submoduleDesc"><?php echo 'R$ ' . number_format($totaldespesa, 2, ',', '.'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
            	<button id="btnSideAtive" class="addButt"><i class="fa-solid fa-plus fa-xs"></i>ﾠNova Fatura</button>
            </div>
            <div class="col-12">
				<div class="module">
				    <div class="row">
						<table style="padding-right: 30px !important;" class="table">
						  <thead>
						    <tr>
						      <th style="padding-left: 20px;" scope="col">#</th>
						      <th scope="col">Título</th>
						      <th scope="col">Cliente</th>
						      <th scope="col"><center>Banco</center></th>
						      <th scope="col">Valor</th>
						      <th scope="col">Data</th>
						      <th style="width: 70px;" scope="col"><center>Tipo</center></th>
						      <th style="width: 70px;" scope="col"><center>Status</center></th>
						      <th style="width: 150px !important;" scope="col"></th>
						      <th style="width: 10px !important;" scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
							<?php
							setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
							date_default_timezone_set('America/Sao_Paulo');
							$consulta = "SELECT * FROM accounts_receivable WHERE status != 'arquivado' ORDER BY id DESC LIMIT 15";
							$con = $conn->query($consulta) or die($conn->error);

							while($dado = $con->fetch_array()) { $type = $dado['type']; ?>
						    <tr>
								<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
								<td><?php echo $dado['title'] ?></td>
								<?php $cliId = $dado['client_id']; $query = "SELECT * FROM clients WHERE id = '$cliId'";
								$responseQuery = mysqli_query($conn, $query);
								while ($super = mysqli_fetch_array($responseQuery)) {$cliente = $super;}; ?>
								<td>
									<img class="supPP" src="../../assets/clients/<?php echo $cliente['pp']; ?>"> 
									<label><?php echo ucfirst($cliente['name']); ?></label>
									<img class="supIcon" style="width: 20px !important" src="../../assets/icons/<?php echo $cliente['plan']; ?>">
								</td>
								<?php $bankId = $dado['bank_id']; $query = "SELECT * FROM bank_accounts WHERE id = '$bankId'";
								$responseQuery = mysqli_query($conn, $query);
								while ($super = mysqli_fetch_array($responseQuery)) {$cliente = $super;}; ?>
								<td>
									<center>
										<img class="supPP" src="<?php echo $cliente['bank_pp']; ?>"> 
									</center>
								</td>
								<td>R$ <?php echo number_format($dado['amount'], 2, ',', '.'); ?></td>
								<td><?php echo date('M d', strtotime($dado['due_date'])) ?></td>
								<td>
									<center>
									<?php 
										if ($type == 'receita') { 
											echo '<i class="fa-regular fa-thumbs-up"></i>'; 
										} elseif ($type == 'despesa') { 
											echo '<i class="fa-regular fa-thumbs-down"></i>'; 
										} 
									?>
									</center>
								</td>
								<td><center><?php 

									$status = $dado['status'];
									if ($status == 'pendente') { 
										echo '<a href="alterState.php?id='.$dado["id"].'&status='.$dado["status"].'"><i class="fa-regular fa-clock"></i></a>'; 
									} elseif ($status == 'arquivado'){ 
										echo '<i class="fa-regular fa-box-archive"></i>'; 
									} elseif ($status == 'ativo') {
										echo '<a href="alterState.php?id='.$dado["id"].'&status='.$dado["status"].'"><i class="fa-regular fa-circle-check"></i></a>'; 
									}

									?></center>
								</td>
								<td class="iconsTd" style="text-align: right;">
								  	<a target="_blank" style="color: white;" href="../../faturas/?hash=<?php echo md5($dado['id']); ?>&client_id=<?php echo $dado['client_id'] ?>&id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-eye"></i></a>
									<?php if ($type == 'receita') {
										$linkFatura = $appLocal.'/faturas/?hash='.md5($dado['id']).'&client_id='.$dado['client_id'].'&id='.$dado['id'];
										echo '<a style="color: white !important;" href="./sendMail.php?id='.$dado["id"].'&link='.$linkFatura.'"><i class="fa-regular fa-envelope"></i></a>';
								  	} ?>
									<?php if (!empty($dado['link'])) {
										echo '<a target="_blank" style="color: white !important;" href="'.$dado["link"].'"><i class="fa-regular fa-share-from-square"></i></a>';
									} ?>
									<a style="color: white !important;" onclick="return confirm('Tenha em mente que esta ação é irreversível!');" href="./remove.php?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-trash-can"></i></a>
								</td>
								<td></td>
						    </tr>
							<?php } ?>
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
		<form method="POST" action="./newFature.php">
			<label>Título:</label>
			<input required placeholder="Insira aqui o título" type="text" name="name"><br>
			<label>Tipo:</label>
			<select required name="type">
				<option value="receita">Receita</option>
				<option value="despesa">Despesa</option>
			</select><br>
			<label>Valor:</label>
			<input required id="newFatureValor" placeholder="Insira aqui o valor" type="text" name="amount"><br>
			<label>Data Compensação:</label>
			<input required type="date" name="date"><br>
			<label>Projeto:</label>
			<select name="projeto">
			    <?php
			    $sql = "SELECT * FROM projects WHERE status = 'ativo'";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
				<?php } } else { echo "<option>Outro</option>"; } mysqli_free_result($result); ?>
			</select><br>
			<label>Banco:</label>
			<select name="bank_id">
			    <?php
			    $sql = "SELECT * FROM bank_accounts WHERE status = 'ativo'";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['bank_name'] ?></option>
				<?php } } else { echo "<option>Outro</option>"; } mysqli_free_result($result); ?>
			</select><br>
			<label>Cliente:</label>
			<select required name="cliente">
			    <?php
			    $sql = "SELECT * FROM clients WHERE status = 'ativo'";
			    $result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] . ' ' . $row['surname'] ?></option>
				<?php } } else { echo "<option>Outro</option>"; } mysqli_free_result($result); ?>
			</select><br>
			<label>Descrição: (Aparecerá na Fatura)</label>
			<textarea style="height: 70px !important;" name="desc"></textarea><br>
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