<?php 

	require "../../config/sql.php";
	$id = $_REQUEST['id'];

	$query = "UPDATE users SET status = 'arquivado' WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; }

?>