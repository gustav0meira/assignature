<?php 
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

require "../../config/cdn.php";
require "../../config/leftbar.php";
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../assets/css/minha-conta.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body>
	<div class="container mc">
		<div class="row">
			<div class="col-3">
				<div class="row">
					<div class="col-12">
						<div onclick="abrirCampoArquivo()" style="background: url('../../assets/pp/<?php echo $user['pp']; ?>');" class="pp"></div>
						<form method="POST" enctype="multipart/form-data" action="<?php echo routeLink('newPP'); ?>" id="formPP">
							<input required type="file" name="pp" id="pp" style="display: none !important;">
							<input required type="hidden" value="<?php echo $user['username'] ?>" name="username">
							<input required type="hidden" value="<?php echo $user['id'] ?>" name="id">
						</form>
					</div>
				</div>
			</div>
			<div class="col-9">
			<?php 
			if (isset($_REQUEST['stats']) AND $_REQUEST['stats'] == 'send') {
				$mailMsg = 'E-mail enviado! Verifique sua caixa de entrada.';
				$mailCor = '#22e67b !important';
			}elseif (!isset($_REQUEST['stats'])) {
				$mailMsg = 'Aguardando verificação de e-mail. Confira sua caixa de entrada!';
				$mailCor = '#e6a522 !important';
			}elseif (isset($_REQUEST['stats']) AND $_REQUEST['stats'] == 'error') {
				$mailMsg = 'Erro no envio! Contacte o suporte.';
				$mailCor = '#e66322 !important';
			}
			if ($user['mailverified'] == 0) {
				echo '
				<div class="col-12">
					<div style="background: '.$mailCor.';" class="module warning">
						<div class="row">
							<div class="col-9">
								<label><i class="fa-solid fa-envelope"></i>ㅤ'.$mailMsg.'</label>
							</div>
							<div class="col-sm">
								<a style="float: right;" href="'.routeLink("resendMail").'">Renviar e-mail</a>
							</div>
						</div>
					</div>
				</div>
				';
			} ?>
			<form id="updateInfo" method="POST" action="<?php echo routeLink('updateMinhaConta'); ?>">
				<div class="module">
					<div class="row inputAccount">
						<div class="col-4">
							<label for="username">Usuário:</label><br>
							<input style="color: #FFFFFF70;" required value="@<?php echo $user['username'] ?>" disabled type="text" name="username">
						</div>
						<div class="col-4">
							<label for="name">Nome:</label><br>
							<input required value="<?php echo $user['name'] ?>" type="text" name="name">
						</div>
						<div class="col-4">
							<label for="surname">Sobrenome:</label><br>
							<input required value="<?php echo $user['surname'] ?>" type="text" name="surname">
						</div>
						<div class="col-6">
							<label for="email">E-mail:</label><br>
							<input required value="<?php echo $user['email'] ?>" type="text" name="email">
						</div>
						<div class="col-6">
							<label for="telefone">Telefone:</label><br>
							<input required id="telefone" value="<?php echo $user['tel'] ?>" type="text" data-inputmask="'mask': '99 9 9999 9999'" name="telefone">
						</div>
						<div class="col-12">
							<hr>
						</div>
						<div class="col-9">
								<label for="telefone">Senha:</label><br>
								<input pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" type="password" name="password" id="password">
								<input type="hidden" name="userId" value="<?php echo $userId; ?>">
						</div>
						<div class="col-3">
							<button form="updatePassword" onclick="submitPasswordForm()">ALTERAR SENHA</button>
						</div>
					</div>
				</div>
				<div class="col-12">
					<p class="phr">Dados para Faturamento:</p>
				</div>
				<div class="col-12">
					<div class="module">
						<div class="row inputAccount">
							<div class="col-7">
								<label for="telefone">Endereço:</label><br>
								<input required value="<?php echo $user['address'] ?>" type="text" name="address">
							</div>
							<div class="col-3">
								<label for="telefone">Cidade:</label><br>
								<input required value="<?php echo $user['city']; ?>" type="text" name="city">
							</div>
							<div class="col-2">
								<label for="telefone">Estado:</label><br>
								<select name="state" required>
									<option></option>
								    <option <?php if($user['state'] == 'AC'){echo 'selected';} ?> value="AC">Acre</option>
								    <option <?php if($user['state'] == 'AL'){echo 'selected';} ?> value="AL">Alagoas</option>
								    <option <?php if($user['state'] == 'AP'){echo 'selected';} ?> value="AP">Amapá</option>
								    <option <?php if($user['state'] == 'AM'){echo 'selected';} ?> value="AM">Amazonas</option>
								    <option <?php if($user['state'] == 'BA'){echo 'selected';} ?> value="BA">Bahia</option>
								    <option <?php if($user['state'] == 'CE'){echo 'selected';} ?> value="CE">Ceará</option>
								    <option <?php if($user['state'] == 'DF'){echo 'selected';} ?> value="DF">Distrito Federal</option>
								    <option <?php if($user['state'] == 'ES'){echo 'selected';} ?> value="ES">Espírito Santo</option>
								    <option <?php if($user['state'] == 'GO'){echo 'selected';} ?> value="GO">Goiás</option>
								    <option <?php if($user['state'] == 'MA'){echo 'selected';} ?> value="MA">Maranhão</option>
								    <option <?php if($user['state'] == 'MT'){echo 'selected';} ?> value="MT">Mato Grosso</option>
								    <option <?php if($user['state'] == 'MS'){echo 'selected';} ?> value="MS">Mato Grosso do Sul</option>
								    <option <?php if($user['state'] == 'MG'){echo 'selected';} ?> value="MG">Minas Gerais</option>
								    <option <?php if($user['state'] == 'PA'){echo 'selected';} ?> value="PA">Pará</option>
								    <option <?php if($user['state'] == 'PB'){echo 'selected';} ?> value="PB">Paraíba</option>
								    <option <?php if($user['state'] == 'PR'){echo 'selected';} ?> value="PR">Paraná</option>
								    <option <?php if($user['state'] == 'PE'){echo 'selected';} ?> value="PE">Pernambuco</option>
								    <option <?php if($user['state'] == 'PI'){echo 'selected';} ?> value="PI">Piauí</option>
								    <option <?php if($user['state'] == 'RJ'){echo 'selected';} ?> value="RJ">Rio de Janeiro</option>
								    <option <?php if($user['state'] == 'RN'){echo 'selected';} ?> value="RN">Rio Grande do Norte</option>
								    <option <?php if($user['state'] == 'RS'){echo 'selected';} ?> value="RS">Rio Grande do Sul</option>
								    <option <?php if($user['state'] == 'RO'){echo 'selected';} ?> value="RO">Rondônia</option>
								    <option <?php if($user['state'] == 'RR'){echo 'selected';} ?> value="RR">Roraima</option>
								    <option <?php if($user['state'] == 'SC'){echo 'selected';} ?> value="SC">Santa Catarina</option>
								    <option <?php if($user['state'] == 'SP'){echo 'selected';} ?> value="SP">São Paulo</option>
								    <option <?php if($user['state'] == 'SE'){echo 'selected';} ?> value="SE">Sergipe</option>
								    <option <?php if($user['state'] == 'TO'){echo 'selected';} ?> value="TO">Tocantins</option>
								    <option <?php if($user['state'] == 'EX'){echo 'selected';} ?> value="EX">Estrangeiro</option></select>
							</div>
							<div class="col-7">
								<label>E-mail Fiscal:</label>
								<input required value="<?php if(empty($user['emailTax'])){echo $user['email'];}else{echo $user['emailTax'];} ?>" type="text" name="emailFiscal">
							</div>
							<div class="col-5">
								<label for="">CPF:</label>
								<input required value="<?php echo $user['cpf'] ?>" id="cpf" type="text" data-inputmask="'mask': '999.999.999-99'" name="cpf">
							</div>
						</div>
					</div>
					<div class="col-12">
						<button form="updateInfo" style="width: 100px; float: right;">SALVAR</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<form id="updatePassword" method="POST" action="<?php echo routeLink('updatePassword'); ?>">
<input pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" type="hidden" name="password" id="senhaHidden">
</form>
<script>
function submitPasswordForm() {
  const senhaInput = document.getElementById('password');
  const senhaHiddenInput = document.getElementById('senhaHidden');
  senhaHiddenInput.value = senhaInput.value;
  document.getElementById('updatePassword').submit();
}
</script>
<script>
function abrirCampoArquivo() {
  document.getElementById('pp').addEventListener('change', function() {
    document.getElementById('formPP').submit();
  });
  document.getElementById('pp').click();
}
</script>
<script>
$(document).ready(function() {
  $('#cpf').inputmask();
});
$(document).ready(function() {
  $('#telefone').inputmask();
});
</script>
</html>