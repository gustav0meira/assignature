<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require '../../config/sql.php';

$mail = new PHPMailer(true);

$id = $_REQUEST['id'];
$client_id = $_REQUEST['client_id'];
$linkFatura = $_REQUEST['link'];
$query = "SELECT * FROM clients WHERE id = '$client_id'";
$queryRequest = mysqli_query($conn, $query) or die("Erro na consulta: " . mysqli_error($conn));
$clients = mysqli_fetch_array($queryRequest);

if ($clients) {
    $clientName = $clients['name'] . ' ' . $clients['surname'];

    try {                
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.hostinger.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'sistema@thecircle.com.br';                     
        $mail->Password   = 'Caquis55#';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;               
    
        $mail->setFrom('sistema@thecircle.com.br', 'The Circle | Sistema');
        $mail->addAddress($clients['email'], $clientName);    
    
        $mail->isHTML(true);                                  
        $mail->Subject = $clients['name'] . ', A sua fatura chegou!';
        $mail->Body    = 'Olá, a sua fatura: ' . $id . ', pode ser acessada clicando <a target="_blank" href="'.$linkFatura.'">aqui</a>.';

        $mail->send();

        echo "<script>window.location.href = './'</script>";
    } catch (Exception $e) {
        echo "<script>alert('Erro na query! Contacte o suporte.')</script>";
        echo "<script>window.location.href = './'</script>";
    }
} else {
    echo "<script>alert('Erro na query! Contacte o suporte.')</script>";
    echo "<script>window.location.href = './'</script>";
}