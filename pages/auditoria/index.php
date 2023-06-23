<?php
$pageName = str_replace('-', ' ', ucwords(basename(__DIR__)));
session_start();
require "../../config/sql.php";
require "../../config/vars.php";

verifyAuth();
$user = catchUser($_SESSION['id'], $conn);

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
</head>
<body>
    <div class="container projectsView">
        <div class="row">
        	<div class="col-12">
        		<div class="module">
					<table style="padding-right: 30px !important;" class="table">
					<thead>
					<tr>
					  <th style="padding-left: 20px;" scope="col">#</th>
					  <th scope="col">Tabela</th>
					  <th scope="col">Ação</th>
					  <th scope="col">Date</th>
					</tr>
					</thead>
					<tbody>
					<?php
					setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
					date_default_timezone_set('America/Sao_Paulo');
					$consulta = "SELECT * FROM audit LIMIT 20";
					$con = $conn->query($consulta) or die($conn->error);
					while($dado = $con->fetch_array()) { ?>
					<tr>
						<th style="padding-left: 20px;">#<?php echo $dado['id'] ?></th>
						<td><?php echo $dado['table_name'] ?></td>
						<td><?php echo $dado['action'] ?></td>
						<td><?php echo date('M d | h:i', strtotime($dado['timestamp'])) ?></td>
					</tr>
					<?php } ?>
					</tbody>
					</table>
        		</div>
        	</div>
        </div>
    </div>
</body>
</html>