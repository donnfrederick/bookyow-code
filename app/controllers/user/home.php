<?php

$login_details = $app->getLogin();

$user_id = $login_details['id'];

$account = findBy('t_account', ['user_id' => $user_id]);

if ($account) {
	$funds = addZeroes($account[0]['account_balance']);
} else {
	$funds = addZeroes(0);
}

$addresses = findBy('t_addresses', ['user_id' => $user_id, 'default_flg' => 1]);

if ($addresses) {
	$address_type = $addresses[0]['address_type'];
} else {
	$address = "-";
	$address_type = 0;
}

$rides = findByDesc('t_ride', ['customer_id' => $user_id, 'status_flg' => 1]);

$transactions = findByDesc('t_transactions', ['user_id' => $user_id]);

function getCustomerQueue($queue_id) {
	$db = new DB();
	$result = $db->execute("SELECT desired_loc, create_date FROM t_customer_queue WHERE id = $queue_id;");

	return $result[0];
}

function getPayment($transaction_id) {
	$payment = findBy('t_cc_payments', ['transaction_id' => $transaction_id]);

	return $payment[0];
}

$on_queue = 0;

if (findBy('t_customer_queue', ['customer_id' => $user_id])) $on_queue = 1;

?>