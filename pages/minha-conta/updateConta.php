<?php 

require '../../config/sql.php';
require '../../config/vars.php';

session_start();
$userId = $_SESSION['id'];
$name 				= $_POST['name'];
$surname 			= $_POST['surname'];
$email 				= $_POST['email'];
$telefone 			= $_POST['telefone'];
$address 			= $_POST['address'];
$city 				= $_POST['city'];
$state 				= $_POST['state'];
$emailFiscal 		= $_POST['emailFiscal'];
$cpf 				= $_POST['cpf'];

$query = "UPDATE users SET name = '$name', surname = '$surname', email = '$email', tel = '$telefone', address = '$address', city = '$city', state = '$state', emailTax = '$emailFiscal', cpf = '$cpf' WHERE id = '$userId'";
$result = mysqli_query($conn, $query);
if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>window.location.href = './'</script>"; }

 ?>