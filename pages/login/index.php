<?php 
require "config/vars.php";
require "config/sql.php";
require "config/cdn.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body>
	<div class="login">
		<form action="#" method="POST">

		<center><img class="logo" src="assets/logo.png"></center>

		<h1>Faça Login no <?php echo $appName ?></h1>
		<p>Para acessar o <?php echo $appName ?> faça login utilizando e-mail e senha.</p>
		<p><?php echo $appLocal ?></p>

		<label>E-mail</label><br>
		<input required placeholder="Insira aqui o seu e-mail..." id="email" type="email" name="email"><br>

		<label>Senha</label><br>
		<input required placeholder="E aqui a sua senha..." id="password" type="password" name="password"><br>

		<button class="login">ENTRAR</button><br>
		<button class="register">CADASTRE-SE</button>

		</form>
	</div>
</body> <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['email']) && isset($_POST['password'])) { login($_POST['email'], $_POST['password'], $conn); } ?>
</html>