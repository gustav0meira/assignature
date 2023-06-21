<?php 

	require "../../config/sql.php";
	
	$title				= $_POST['title'];
	$date				= $_POST['date'];
	$client_id			= $_POST['client_id'];
	$supervisor_id		= $_POST['supervisor_id'];
	$link				= $_POST['link'];
	$briefing			= $_POST['briefing'];

	$query = "INSERT INTO projects (supervisor, client_id, name, description, link, end_date) VALUES ('$supervisor_id', '$client_id', '$title', '$briefing', '$link', '$date')";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; }

?>