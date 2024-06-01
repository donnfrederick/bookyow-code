<?php

if (isset($_POST['account_submit'])) {
	if ($account) {
		$account_details = $account[0];
		$account_id = $account_details['id'];
		$funds = $account_details['account_balance'];

		$funds_update = $funds + $_POST['account_amount'];

		if (!update(['account_balance' => $funds_update], 't_account', ['id' => $account_id])) {
			die('Unable to update account');
		}
	} else {
		if (!insert(['user_id' => $user_id, 'account_balance' => $_POST['account_amount']], 't_account')) {
			die('Unable to create account');
		}
	}

	$transaction = array(
		'user_id' => $user_id,
		'amount' => $_POST['account_amount']
	);

	if (!insert($transaction, 't_transactions')) {
		die('Error on transaction');
	} else {
		$transaction_details = findDesc('t_transactions');
	}

	$payment = array(
		'user_id' => $user_id,
		'amount_paid' => $_POST['account_amount'],
		'transaction_id' => $transaction_details['id'],
		'account_name' => $_POST['account_name'],
		'account_number' => $_POST['account_number'],
		'account_cvc' => $_POST['account_cvc'],
		'account_exp' => $_POST['account_exp']
	);

	if (!insert($payment, 't_cc_payments')) {
		die('Error on payment');
	}

	header("Refresh:0");
}

?>