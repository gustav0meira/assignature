<?php 

	require "../../config/sql.php";
	$id = $_REQUEST['id'];
	$status = $_REQUEST['status'];

	if ($status == 'ativo') {
		$status = 'pendente';
	} elseif ($status == 'pendente'){
		$status = 'ativo';
	} else{
		header('Location: ./');
	}

	$query = "UPDATE accounts_receivable SET status = '$status' WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; }

?>