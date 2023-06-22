<?php 

	require "../../config/sql.php";
	$id = $_REQUEST['id'];

	$query = "UPDATE clients SET status = 'arquivado' WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './?id-".$id."'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './?id-".$id."'</script>"; }

?>