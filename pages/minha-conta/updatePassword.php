<?php 

require '../../config/sql.php';
require '../../config/vars.php';

session_start();
$userId 	= $_SESSION['id'];
$password   = hash('sha256', $_POST['password']);

$query = "UPDATE users SET password='$password' WHERE id = '$userId'";
$result = mysqli_query($conn, $query);
if ($result) { echo "<script>alert('Sucesso!');window.location.href = './'</script>";  } else { echo "<script>window.location.href = './'</script>";  }

 ?>