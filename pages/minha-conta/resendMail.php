<?php 

require '../../config/sql.php';
require '../../config/vars.php';
require '../../vendor/autoload.php';
session_start();
$userId = $_SESSION['id'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$user = catchUser($userId, $conn);
$mail = new PHPMailer(true);
try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sistema@thecircle.com.br';
    $mail->Password   = 'Caquis55#';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('sistema@thecircle.com.br', 'Sistema | The Circle');
    $mail->addAddress($user['email'], $user['name']);

    $mail->CharSet = 'UTF-8';

    $mail->isHTML(true);
    $mail->Subject = 'Verificação de E-mail - '.$appName.': Ação Necessária!';
	$mail->Body = '
	<style>
	    body {
	        margin: 0px;
	        font-family: Poppins, Helvetica, Arial;
	        font-weight: 300;
	    }
	    label {
	        font-size: 2rem;
	        color: #242522;
	        font-weight: 400;
	    }
	    .mail .top {
	        background-color: #8774E1;
	        padding: 30px;
	        width: 100%;
	    }
	    .mail .content {
	        padding: 50px;
	    }
	    .mail button {
	        padding: 15px 20px 15px 20px;
	        cursor: pointer;
	        border: none;
	        color: white;
	        background: #8774E1;
	        border-radius: 10px;
	        margin-top: 10px;
	        margin-bottom: 20px;
	        font-family: Poppins, Helvetica, Arial;
	    }
	    p.link {
	        font-weight: 300;
	        font-size: 0.8rem;
	        text-align: center;
	    }
	    .bottom {
	        position: absolute;
	        bottom: 0;
	        left: 0;
	        background: #00000010;
	        color: #00000070;
	        padding-top: 10px;
	        margin-top: 100px;
	        width: 100%;
	        font-size: 0.6rem;
	    }
	</style>

	<div class="mail">
	    <div class="top"></div>
	    <div class="content">
	        <label>Olá, '.$user["name"].'</label>
	        <p>Para realizar a verificação do seu e-mail na plataforma do '.$appName.', por favor, clique no botão abaixo ou copie e cole o link no seu navegador. Agradecemos pela sua atenção e estamos à disposição para qualquer dúvida ou suporte necessário.</p>
	        <a target="_blank" href="'.$appLocal.'verificar-email.php?hash='.md5($user["name"]).'&id='.$user["id"].'"><center><button style="padding: 15px 20px 15px 20px; cursor: pointer; border: none; color: white; background: #8774E1; border-radius: 10px; margin-top: 10px; margin-bottom: 20px; font-family: Poppins, Helvetica, Arial;">VERIFICAR</button></center></a>
	        <p class="link" style="font-weight: 300; font-size: 0.8rem; text-align: center;">'.$appLocal.'verificar-email.php?hash='.md5($user["name"]).'&id='.$user["id"].'</p>
	    </div>
	    <div class="bottom">
	        <center>
	            <p class="copy">Copyright RespondeZap ©</p>
	        </center>
	    </div>
	</div>';

    $mail->send();
    header('Location: ./?stats=send');
} catch (Exception $e) {
    header('Location: ./?stats=error');
}

?>