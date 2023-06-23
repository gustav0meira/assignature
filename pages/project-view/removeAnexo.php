<?php 

	require "../../config/sql.php";
	$id 		= $_REQUEST['id'];
	$project 	= $_REQUEST['projId'];

	$query = "DELETE FROM anexos WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './?id=".$project."'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './?id=".$project."'</script>"; }

?>