<?php

$on_queue = 0;
$queue_details = null;
$customer_details = null;

$rider_data = $app->getLogin();
$rider_id = $rider_data['id'];
$rider_details = find($rider_id, 'm_user');

if ($rider_data = findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 2])) {
	$queue_details = find($rider_data[0]['customer_queue'], 't_customer_queue');
	$on_queue = 1;
	$customer_details = find($queue_details['customer_id'], 'm_user');
}

if ($rider_data = findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 3])) {
	$queue_details = find($rider_data[0]['customer_queue'], 't_customer_queue');
	$on_queue = 1;
	$customer_details = find($queue_details['customer_id'], 'm_user');
}

$is_verified = 0;

if (findBy('t_vehicle_info', ['verified_flg' => 1, 'rider_id' => $rider_id])) {
	$is_verified = 1;
}

$queue_verification = 0;

if (findBy('t_vehicle_info', ['verified_flg' => 0, 'rider_id' => $rider_id])) {
	$queue_verification = 1;
}

?>