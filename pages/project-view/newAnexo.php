<?php
require '../../config/sql.php';
require '../../config/vars.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['newAnexo'])) {
    $file = $_FILES['newAnexo'];
    $id = $_REQUEST['project_id'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $file['tmp_name'];

        $uploadDir = '../../assets/anexos/';
        $fileName = $file['name'];
        $destination = $uploadDir . $fileName;

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($tempFilePath, $destination)) {
            $query = "INSERT INTO anexos (project_id, name, local) VALUES ('$id', '$fileName', '$fileName')";
            $result = mysqli_query($conn, $query);
            if ($result) { echo "<script>window.location.href = './?id=".$id."'</script>"; }else { echo "<script>window.location.href = './?id=".$id."'</script>";  }
        } else {
            echo "<script>window.location.href = './?id=".$id."'</script>";
        }
    } else {
        echo "<script>window.location.href = './?id=".$id."'</script>";
    }
}else{
    echo 'erro';
}
?>