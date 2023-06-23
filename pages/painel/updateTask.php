<?php 

	require "../../config/sql.php";
	$id 		= $_REQUEST['id'];
	$projId 	= $_REQUEST['projId'];
	$status 	= $_REQUEST['status'];
	if ($status == 1) { $status = 0; } elseif ($status == 0) { $status = 1; }

	$query = "UPDATE tasks SET status = $status WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { 
		echo "<script>window.location.href = './?id=".$projId."'</script>"; 
	} else { 
		echo "<script>alert('Erro na query! Contacte o suporte.')</script>";
		echo "<script>window.location.href = './?id=".$projId."'</script>";
	}

?>