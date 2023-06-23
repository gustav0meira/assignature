<?php 

	require "sql.php";
	$id 		= $_REQUEST['id'];

	$query = "DELETE FROM notifications WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>history.back();</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>history.back();</script>"; }

?>