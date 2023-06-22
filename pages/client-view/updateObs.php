<?php 

	require "../../config/sql.php";
	$id 	= $_REQUEST['id'];
	$obs 	= $_REQUEST['obs'];

	$query = "UPDATE clients SET obs = '$obs' WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './?id=".$id."'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './?id=".$id."'</script>"; }

?>