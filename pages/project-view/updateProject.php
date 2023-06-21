<?php 

	require "../../config/sql.php";
	$id 			= $_REQUEST['id'];
	$title 			= $_REQUEST['title'];
	$description 	= $_REQUEST['description'];

	$query = "UPDATE projects SET name = '$title', description = '$description' WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './?id=".$id."'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './?id=".$id."'</script>"; }

?>