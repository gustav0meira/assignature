<?php 

ini_set('display_errors', 0);

require '../../config/sql.php';
require '../../config/vars.php';
require '../../config/cdn.php';

session_start();
$userId 			= $_SESSION['id'];
$userRequested 		= $_REQUEST['id'];

if ($userId == $userRequested) {
	$query = "UPDATE users SET mailverified = 1 WHERE id = '$userRequested'";

	$result = mysqli_query($conn, $query);
	if ($result) { 
		$stats = 'success'; 
		$title = 'E-mail verificado!';
		$desc = 'Em alguns segundos você será redirecionado de volta ao sistema.';
		$color = '#00ff0a';
		$icon = 'fa-circle-check';
	}
}else { 
	$stats = 'error'; 
	$title = 'Você não está logado!';
	$desc = 'Certifique-se de estar logado para verificar o seu e-mail!';
	$color = '#ff7800';
	$icon = 'fa-circle-info';
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://kit.fontawesome.com/3fd2d35481.js" crossorigin="anonymous"></script>
	<style>
		body{
			background: #242522;
			font-family: Poppins, Helvetica, Arial;
			color: white;
			font-weight: 300;
		}
		.centerAlign{
			width: 50%;
			position: relative;
			top: 50%;
			left: 50%;
			transform: translate3d(-50%, -50%, 0px);
		}
		svg{
			font-size: 7rem;
		}
	</style>
</head>
<body>
	<div class="centerAlign">
		<center>
			<i style="color: <?php echo $color ?>;" class="fa-solid <?php echo $icon ?>"></i>
			<h1><?php echo $title ?></h1>
			<p><?php echo $desc ?></p>
		</center>
	</div>
</body>
</html>

<script>
setTimeout(function() {
  window.location.href = "./";
}, 5000);
</script>