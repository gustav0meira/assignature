<?php 

	require "../../config/sql.php";
	$id 		= $_REQUEST['id'];
	$date 	= date('Y-m-d', strtotime($_REQUEST['prazo']));

	$query = "UPDATE tasks SET prazo = '$date' WHERE id = $id";
	$result = mysqli_query($conn, $query);
	if ($result) { 
		echo "<script>window.location.href = './'</script>"; 
	} else { 
		echo "<script>alert('Erro na query! Contacte o suporte.')</script>";
		echo "<script>window.location.href = './'</script>";
	}

?>