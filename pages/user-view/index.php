<?php
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);
$userInput = catchUser($_REQUEST['id'], $conn);

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
        		<div style="background: url('../../assets/pp/<?php echo $userInput['pp'] ?>');" class="clientPP"></div>

				<h1 style="margin-top: 30px;" class="moduleTitle">#observações</h1>
				<form method="POST" action="updateObs.php">
					<textarea name="obs" style="height: 230px; background: #56585a;"><?php echo $userInput['obs'] ?></textarea>
					<input type="hidden" value="<?php echo $userInput['id'] ?>" name="id">
					<button class="send">ATUALIZAR</button>
				</form>
        	</div>
        	<div class="col-9">
        		<div class="module">
					<div class="row inputAccount">
						<div class="col-4">
							<label for="username">Usuário:</label><br>
							<input disabled style="color: #FFFFFF70;" required value="@<?php echo $userInput['username'] ?>" disabled type="text" name="username">
						</div>
						<div class="col-4">
							<label for="name">Nome:</label><br>
							<input disabled required value="<?php echo $userInput['name'] ?>" type="text" name="name">
						</div>
						<div class="col-4">
							<label for="surname">Sobrenome:</label><br>
							<input disabled required value="<?php echo $userInput['surname'] ?>" type="text" name="surname">
						</div>
						<div class="col-6">
							<label for="email">E-mail:</label><br>
							<input disabled required value="<?php echo $userInput['email'] ?>" type="text" name="email">
						</div>
						<div class="col-6">
							<label for="telefone">Telefone:</label><br>
							<input disabled required id="telefone" value="<?php echo $userInput['tel'] ?>" type="text" data-inputmask="'mask': '99 9 9999 9999'" name="telefone">
						</div>
					</div>
				</div>
				<div class="col-12">
					<p class="phr">Dados para Faturamento:</p>
				</div>
				<div class="col-12">
					<input disabled type="hidden" name="id" value="<?php echo $userInput['id'] ?>">
					<div class="module">
						<div class="row inputAccount">
							<div class="col-7">
								<label for="telefone">Endereço:</label><br>
								<input disabled required value="<?php echo $userInput['address'] ?>" type="text" name="address">
							</div>
							<div class="col-3">
								<label for="telefone">Cidade:</label><br>
								<input disabled required value="<?php echo $userInput['city']; ?>" type="text" name="city">
							</div>
							<div class="col-2">
								<label for="telefone">Estado:</label><br>
								<select disabled name="state" required>
									<option></option>
								    <option <?php if($userInput['state'] == 'AC'){echo 'selected';} ?> value="AC">Acre</option>
								    <option <?php if($userInput['state'] == 'AL'){echo 'selected';} ?> value="AL">Alagoas</option>
								    <option <?php if($userInput['state'] == 'AP'){echo 'selected';} ?> value="AP">Amapá</option>
								    <option <?php if($userInput['state'] == 'AM'){echo 'selected';} ?> value="AM">Amazonas</option>
								    <option <?php if($userInput['state'] == 'BA'){echo 'selected';} ?> value="BA">Bahia</option>
								    <option <?php if($userInput['state'] == 'CE'){echo 'selected';} ?> value="CE">Ceará</option>
								    <option <?php if($userInput['state'] == 'DF'){echo 'selected';} ?> value="DF">Distrito Federal</option>
								    <option <?php if($userInput['state'] == 'ES'){echo 'selected';} ?> value="ES">Espírito Santo</option>
								    <option <?php if($userInput['state'] == 'GO'){echo 'selected';} ?> value="GO">Goiás</option>
								    <option <?php if($userInput['state'] == 'MA'){echo 'selected';} ?> value="MA">Maranhão</option>
								    <option <?php if($userInput['state'] == 'MT'){echo 'selected';} ?> value="MT">Mato Grosso</option>
								    <option <?php if($userInput['state'] == 'MS'){echo 'selected';} ?> value="MS">Mato Grosso do Sul</option>
								    <option <?php if($userInput['state'] == 'MG'){echo 'selected';} ?> value="MG">Minas Gerais</option>
								    <option <?php if($userInput['state'] == 'PA'){echo 'selected';} ?> value="PA">Pará</option>
								    <option <?php if($userInput['state'] == 'PB'){echo 'selected';} ?> value="PB">Paraíba</option>
								    <option <?php if($userInput['state'] == 'PR'){echo 'selected';} ?> value="PR">Paraná</option>
								    <option <?php if($userInput['state'] == 'PE'){echo 'selected';} ?> value="PE">Pernambuco</option>
								    <option <?php if($userInput['state'] == 'PI'){echo 'selected';} ?> value="PI">Piauí</option>
								    <option <?php if($userInput['state'] == 'RJ'){echo 'selected';} ?> value="RJ">Rio de Janeiro</option>
								    <option <?php if($userInput['state'] == 'RN'){echo 'selected';} ?> value="RN">Rio Grande do Norte</option>
								    <option <?php if($userInput['state'] == 'RS'){echo 'selected';} ?> value="RS">Rio Grande do Sul</option>
								    <option <?php if($userInput['state'] == 'RO'){echo 'selected';} ?> value="RO">Rondônia</option>
								    <option <?php if($userInput['state'] == 'RR'){echo 'selected';} ?> value="RR">Roraima</option>
								    <option <?php if($userInput['state'] == 'SC'){echo 'selected';} ?> value="SC">Santa Catarina</option>
								    <option <?php if($userInput['state'] == 'SP'){echo 'selected';} ?> value="SP">São Paulo</option>
								    <option <?php if($userInput['state'] == 'SE'){echo 'selected';} ?> value="SE">Sergipe</option>
								    <option <?php if($userInput['state'] == 'TO'){echo 'selected';} ?> value="TO">Tocantins</option>
								    <option <?php if($userInput['state'] == 'EX'){echo 'selected';} ?> value="EX">Estrangeiro</option></select>
							</div>
							<div class="col-7">
								<label>E-mail Fiscal:</label>
								<input disabled required value="<?php if(empty($userInput['emailTax'])){echo $userInput['email'];}else{echo $userInput['emailTax'];} ?>" type="text" name="emailFiscal">
							</div>
							<div class="col-5">
								<label for="">CPF:</label>
								<input disabled required value="<?php echo $userInput['cpf'] ?>" id="cpf" type="text" data-inputmask="'mask': '999.999.999-99'" name="cpf">
							</div>
						</div>
					</div>
				</div>
        	</div>
        </div>
    </div>
</body>
</html>