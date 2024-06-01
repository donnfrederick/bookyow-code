<?php

$login_details = $app->getLogin();

$user_id = $login_details['id'];

$transactions = findByDesc('t_transactions', ['user_id' => $user_id]);

function getPayment($transaction_id) {
	$payment = findBy('t_cc_payments', ['transaction_id' => $transaction_id]);

	if ($payment) {
		return $payment[0];
	} else {
		return null;
	}
}

?>