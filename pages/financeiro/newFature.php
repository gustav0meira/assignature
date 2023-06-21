<?php 

require "../../config/sql.php";

$name 			= $_POST['name'];
$amount 		= $_POST['amount'];
$amount 		= str_replace('.', '', $amount); // Remover pontos de milhar
$amount 		= str_replace(',', '.', $amount); // Substituir vírgula por ponto decimal
$amount 		= preg_replace("/[^0-9.]/", "", $amount); // Filtrar apenas os números
$projeto 		= $_POST['projeto'];
$cliente 		= $_POST['cliente'];
$bank_id		= $_POST['bank_id'];
$desc 			= $_POST['desc'];
$type 			= $_POST['type'];
$date 			= $_POST['date'];

$query = "INSERT INTO accounts_receivable (project_id, client_id, bank_id, amount, title, description, type, due_date) 
		  VALUES ('$projeto', '$cliente', '$bank_id', '$amount', '$name', '$desc', '$type', '$date')";

$result = mysqli_query($conn, $query);

if ($result) { 
	echo "<script>window.location.href = './'</script>"; 
} else { 
	echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; 
}

?>