<?php 

	session_start();
	require "../../config/sql.php";
	require "../../config/vars.php";
	$userId = $_SESSION['id'];

	$query = "UPDATE users SET logged = 1 WHERE id = $userId";
	$result = mysqli_query($conn, $query);
	if ($result) { session_destroy(); echo "<script>window.location.href = '../login/'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = '../painel/'</script>"; }

?>