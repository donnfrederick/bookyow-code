<?php

$login_details = $app->getLogin();

$rider_id = $login_details['id'];

$account = findBy('t_account', ['user_id' => $rider_id]);

if ($account) {
	$funds = addZeroes($account[0]['account_balance']);
} else {
	$funds = addZeroes(0);
}

$rides = findByDesc('t_ride', ['rider_id' => $rider_id, 'status_flg' => 1]);

$transactions = findByDesc('t_transactions', ['user_id' => $rider_id]);

function getPayment($transaction_id) {
	$payment = findBy('t_cc_payments', ['transaction_id' => $transaction_id]);

	return $payment[0];
}

function getCustomerQueue($queue_id) {
	$db = new DB();
	$result = $db->execute("SELECT customer_id, desired_loc, create_date FROM t_customer_queue WHERE id = $queue_id;");

	return $result[0];
}

$on_ride = 0;

if (findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 2])) {
	$on_ride = 1;
}

$on_ride_2 = 0;

if (findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 3])) {
	$on_ride_2 = 1;
}