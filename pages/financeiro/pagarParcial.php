<?php
	require "../../config/sql.php";
	$id = $_REQUEST['id'];
	$bank_id = $_REQUEST['bank_id'];
	$valor = $_REQUEST['valor'];

	// Verifica se o valor contém uma vírgula
	if (strpos($valor, ',') !== false) {
		// Substitui a vírgula por um ponto
		$valor = str_replace(',', '.', $valor);
	}

	$query = "UPDATE accounts_receivable SET amount = amount - $valor WHERE id = $id";
	$result = mysqli_query($conn, $query);

	if ($result) { 
		// Recupera o valor atual de bank_amount
		$query = "SELECT bank_amount FROM bank_accounts WHERE id = $bank_id";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
		$bank_amount = $row['bank_amount'];

		// Realiza a adição manualmente
		$new_bank_amount = $bank_amount + $valor;

		// Atualiza o valor de bank_amount
		$query = "UPDATE bank_accounts SET bank_amount = $new_bank_amount WHERE id = $bank_id";
		$result = mysqli_query($conn, $query);

		if ($result) { 
			header('Location: ./');
		} else { 
			header('Location: ./');
		}
	} else { 
		header('Location: ./');
	}
	header('Location: ./');
?>