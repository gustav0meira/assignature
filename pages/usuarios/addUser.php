<?php 

	require "../../config/sql.php";

	$name					= $_REQUEST['name'];
	$username				= strtolower($_REQUEST['name']);
	$surname				= $_REQUEST['surname'];
	$email					= $_REQUEST['email'];
	$phone					= $_REQUEST['phone'];
	$obs					= $_REQUEST['obs'];
	$job_function			= $_REQUEST['job_function'];
	$password				= hash('sha256', $_REQUEST['password']);

	$query = "INSERT INTO users (username, job_function, name, surname, email, password, tel, obs) VALUES ('$username', '$job_function', '$name', '$surname', '$email', '$password', '$phone', '$obs')";
	$result = mysqli_query($conn, $query);
	if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './'</script>"; }

 ?>