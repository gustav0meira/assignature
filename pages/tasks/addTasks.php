<?php 

	require "../../config/sql.php";
	
	$title				= $_POST['title'];
	$project_id			= $_POST['project_id'];
	$responsavel		= $_POST['responsavel'];
	$prazo				= $_POST['prazo'];

	$query = "INSERT INTO tasks (responsavel, projeto, title, prazo) VALUES ('$responsavel', '$project_id', '$title', '$prazo')";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; }

?>