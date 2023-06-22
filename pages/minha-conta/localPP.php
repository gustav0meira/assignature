<?php
require '../../config/sql.php';
require '../../config/vars.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pp'])) {
    $file = $_FILES['pp'];
    $username = $_REQUEST['username'];
    $id = $_REQUEST['id'];

    // Verifica se houve algum erro no upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $file['tmp_name'];

        // Define o diretório de destino e o nome do arquivo final
        $uploadDir = '../../assets/pp/';
        $fileName = $username . '.jpg';
        $destination = $uploadDir . $fileName;

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($tempFilePath, $destination)) {
			$query = "UPDATE users SET pp ='$fileName' WHERE id = '$id'";
			$result = mysqli_query($conn, $query);
			if ($result) { echo "<script>window.location.href = './'</script>"; }else { echo "<script>window.location.href = './'</script>";  }
        } else {
        	echo "<script>window.location.href = './'</script>";
        }
    } else {
    	echo "<script>window.location.href = './'</script>";
    }
}
?>