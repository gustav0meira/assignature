<?php 

require '../../config/sql.php';
require '../../config/vars.php';

session_start();
$id 			= $_POST['id'];
$name 				= $_POST['name'];
$surname 			= $_POST['surname'];
$email 				= $_POST['email'];
$telefone 			= $_POST['telefone'];
$address 			= $_POST['address'];
$city 				= $_POST['city'];
$state 				= $_POST['state'];
$emailFiscal 		= $_POST['emailFiscal'];
$cpf 				= $_POST['cpf'];

$query = "UPDATE clients SET name = '$name', surname = '$surname', email = '$email', phone = '$telefone', address = '$address', city = '$city', state = '$state', emailTax = '$emailFiscal', cpf_cnpj = '$cpf' WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if ($result) { echo "<script>window.location.href = './?id=".$id."'</script>"; }else { echo "<script>alert('Erro na query! Contacte o suporte.')</script>"; echo "<script>window.location.href = './?id=".$id."'</script>"; }

 ?>