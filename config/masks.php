<?php 

function maskPhone($phoneNumber) {
  $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

  // Define a máscara
  $mask = '(**) * ****-****';

  // Obtém o tamanho do número de telefone
  $phoneNumberLength = strlen($phoneNumber);

  // Substitui os dígitos do número pela máscara
  for ($i = 0; $i < $phoneNumberLength; $i++) {
    $mask = preg_replace('/\*/', $phoneNumber[$i], $mask, 1);
  }

  return $mask;
}

 ?>