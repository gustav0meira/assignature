<?php 

	require "../../config/sql.php";

	$supervisor_id			= $_REQUEST['supervisor_id'];
	$name					= $_REQUEST['name'];
	$surname				= $_REQUEST['surname'];
	$email					= $_REQUEST['email'];
	$phone					= $_REQUEST['phone'];
	$obs					= $_REQUEST['obs'];

	$query = "INSERT INTO clients (id_supervisor, name, surname, email, phone, obs) VALUES ('$supervisor_id', '$name', '$surname', '$email', '$phone', '$obs')";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; }

 ?>