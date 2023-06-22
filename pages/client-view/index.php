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

$clientId = $_REQUEST['id'];
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
    <link rel="stylesheet" type="text/css" href="../../assets/css/minha-conta.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/projetos.css">
    <style>
    	body{
    		overflow-y: auto !important;
    	}
    </style>
</head>
<body>
    <div class="container projectsView">
        <div class="row">
        	<div class="col-3">
        		<div style="background: url('../../assets/clients/<?php echo $client['pp'] ?>');" class="clientPP"></div>

				<h1 style="margin-top: 30px;" class="moduleTitle">#supervisor</h1>
				<?php 
				$supervisor = $client['id_supervisor'];
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
				<form method="POST" action="updateObs.php">
					<textarea name="obs" style="height: 230px; background: #56585a;"><?php echo $client['obs'] ?></textarea>
					<input type="hidden" value="<?php echo $client['id'] ?>" name="id">
					<button class="send">ATUALIZAR</button>
				</form>
        	</div>
        	<div class="col-9">
				<form id="updateInfo" method="POST" action="updateClient.php">
        		<div class="module">
					<div class="row inputAccount">
						<div class="col-4">
							<label for="username">Usuário:</label><br>
							<input style="color: #FFFFFF70;" required value="@<?php echo $client['username'] ?>" disabled type="text" name="username">
						</div>
						<div class="col-4">
							<label for="name">Nome:</label><br>
							<input required value="<?php echo $client['name'] ?>" type="text" name="name">
						</div>
						<div class="col-4">
							<label for="surname">Sobrenome:</label><br>
							<input required value="<?php echo $client['surname'] ?>" type="text" name="surname">
						</div>
						<div class="col-6">
							<label for="email">E-mail:</label><br>
							<input required value="<?php echo $client['email'] ?>" type="text" name="email">
						</div>
						<div class="col-6">
							<label for="telefone">Telefone:</label><br>
							<input required id="telefone" value="<?php echo $client['phone'] ?>" type="text" data-inputmask="'mask': '99 9 9999 9999'" name="telefone">
						</div>
					</div>
				</div>
				<div class="col-12">
					<p class="phr">Dados para Faturamento:</p>
				</div>
				<div class="col-12">
					<input type="hidden" name="id" value="<?php echo $client['id'] ?>">
					<div class="module">
						<div class="row inputAccount">
							<div class="col-7">
								<label for="telefone">Endereço:</label><br>
								<input required value="<?php echo $client['address'] ?>" type="text" name="address">
							</div>
							<div class="col-3">
								<label for="telefone">Cidade:</label><br>
								<input required value="<?php echo $client['city']; ?>" type="text" name="city">
							</div>
							<div class="col-2">
								<label for="telefone">Estado:</label><br>
								<select name="state" required>
									<option></option>
								    <option <?php if($client['state'] == 'AC'){echo 'selected';} ?> value="AC">Acre</option>
								    <option <?php if($client['state'] == 'AL'){echo 'selected';} ?> value="AL">Alagoas</option>
								    <option <?php if($client['state'] == 'AP'){echo 'selected';} ?> value="AP">Amapá</option>
								    <option <?php if($client['state'] == 'AM'){echo 'selected';} ?> value="AM">Amazonas</option>
								    <option <?php if($client['state'] == 'BA'){echo 'selected';} ?> value="BA">Bahia</option>
								    <option <?php if($client['state'] == 'CE'){echo 'selected';} ?> value="CE">Ceará</option>
								    <option <?php if($client['state'] == 'DF'){echo 'selected';} ?> value="DF">Distrito Federal</option>
								    <option <?php if($client['state'] == 'ES'){echo 'selected';} ?> value="ES">Espírito Santo</option>
								    <option <?php if($client['state'] == 'GO'){echo 'selected';} ?> value="GO">Goiás</option>
								    <option <?php if($client['state'] == 'MA'){echo 'selected';} ?> value="MA">Maranhão</option>
								    <option <?php if($client['state'] == 'MT'){echo 'selected';} ?> value="MT">Mato Grosso</option>
								    <option <?php if($client['state'] == 'MS'){echo 'selected';} ?> value="MS">Mato Grosso do Sul</option>
								    <option <?php if($client['state'] == 'MG'){echo 'selected';} ?> value="MG">Minas Gerais</option>
								    <option <?php if($client['state'] == 'PA'){echo 'selected';} ?> value="PA">Pará</option>
								    <option <?php if($client['state'] == 'PB'){echo 'selected';} ?> value="PB">Paraíba</option>
								    <option <?php if($client['state'] == 'PR'){echo 'selected';} ?> value="PR">Paraná</option>
								    <option <?php if($client['state'] == 'PE'){echo 'selected';} ?> value="PE">Pernambuco</option>
								    <option <?php if($client['state'] == 'PI'){echo 'selected';} ?> value="PI">Piauí</option>
								    <option <?php if($client['state'] == 'RJ'){echo 'selected';} ?> value="RJ">Rio de Janeiro</option>
								    <option <?php if($client['state'] == 'RN'){echo 'selected';} ?> value="RN">Rio Grande do Norte</option>
								    <option <?php if($client['state'] == 'RS'){echo 'selected';} ?> value="RS">Rio Grande do Sul</option>
								    <option <?php if($client['state'] == 'RO'){echo 'selected';} ?> value="RO">Rondônia</option>
								    <option <?php if($client['state'] == 'RR'){echo 'selected';} ?> value="RR">Roraima</option>
								    <option <?php if($client['state'] == 'SC'){echo 'selected';} ?> value="SC">Santa Catarina</option>
								    <option <?php if($client['state'] == 'SP'){echo 'selected';} ?> value="SP">São Paulo</option>
								    <option <?php if($client['state'] == 'SE'){echo 'selected';} ?> value="SE">Sergipe</option>
								    <option <?php if($client['state'] == 'TO'){echo 'selected';} ?> value="TO">Tocantins</option>
								    <option <?php if($client['state'] == 'EX'){echo 'selected';} ?> value="EX">Estrangeiro</option></select>
							</div>
							<div class="col-7">
								<label>E-mail Fiscal:</label>
								<input required value="<?php if(empty($client['emailTax'])){echo $client['email'];}else{echo $client['emailTax'];} ?>" type="text" name="emailFiscal">
							</div>
							<div class="col-5">
								<label for="">CPF:</label>
								<input required value="<?php echo $client['cpf_cnpj'] ?>" id="cpf" type="text" data-inputmask="'mask': '999.999.999-99'" name="cpf">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button form="updateInfo" style="width: 100px; float: right;">SALVAR</button>
						</div>
					</div>
					</form>
					<div style="margin-top: 20px;" class="row">
						<div class="col-12">
							<div class="module">
								<table class="table">
								  <thead>
								    <tr>
								      <th style="padding-left: 20px;" scope="col">#</th>
								      <th scope="col">Título</th>
								      <th scope="col">Supervisor</th>
								      <th scope="col">Prazo</th>
								      <th style="width: 130px;" scope="col"></th>
								    </tr>
								  </thead>
								  <tbody>
									<?php
									setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
									date_default_timezone_set('America/Sao_Paulo');
									$consulta = "SELECT * FROM projects WHERE status = 'ativo' AND client_id = $clientId ORDER BY end_date ASC LIMIT 5";
									$con = $conn->query($consulta) or die($conn->error);

									if (mysqli_num_rows($con) > 0) {
									while($dado = $con->fetch_array()) { ?>
									<?php $prazo = strtotime($dado['end_date']) - strtotime(date('Y-m-d')); $prazo = round($prazo / (60 * 60 * 24)); ?>
								    <tr>
										<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
										<td><?php echo $dado['name'] ?></td>
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
											<a onclick="return confirm('Tenha em mente que esta ação é irreversível!')" href="../projetos/remove.php?id=<?php echo $dado['id'] ?>"><i class="fa-regular fa-trash-can"></i></a>
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
        </div>
    </div>
</body>
</html>