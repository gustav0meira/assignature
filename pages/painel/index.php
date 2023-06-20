<?php 
require "config/vars.php";
require "config/sql.php";

session_start(); verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

require "config/cdn.php";
require "config/leftbar.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/painel.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-3">
				<div class="module">
					<div class="row">
						<div class="col-3">
							<i class="fa-solid fa-pen-nib item-module align"></i>
						</div>
						<div class="col-sm">
							<label class="submoduleTitle">Assinaturas</label><br>
							<label class="submoduleDesc">0</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3">
				<div class="module">
					<div class="row">
						<div class="col-3">
							<i class="fa-solid fa-user item-module align"></i>
						</div>
						<div class="col-sm">
							<label class="submoduleTitle">Clientes</label><br>
							<label class="submoduleDesc">0</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="module">
					<div class="row">
						<div class="col-1">
							<i class="fa-solid fa-file item-module align"></i>
						</div>
						<div class="col-sm">
							<label style="margin-left: 17px;" class="submoduleTitle">Ultimo Contrato</label><br>
							<label style="margin-left: 17px;" class="submoduleDesc">Contrato de locação - Apartamento 156 | Ibira [...]</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">
				<h1 class="moduleTitle">#contratos</h1>
				<div class="module">
					<div class="row">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>