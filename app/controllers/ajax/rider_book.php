<?php

$app->checkXHR();

if ($_POST['request'] == 'find_queue') {
	if ($queues = findBy('t_customer_queue', ['status_flg' => 0])) {
		foreach ($queues as $queue) {
			if ($user_data = find($queue['customer_id'], 'm_user')) {
				echo '<div class="content-card-item text-left"><div class="card-item-header"><div class="header-left"><p>'.$user_data['firstname'].' '.$user_data['lastname'].'</p></div></div><div class="content-ride-to"><h5>Destination:</h5><p>'.$queue['desired_loc'].'</p></div><button type="button" onclick="acceptBooking('.numhash($queue['id']).')" class="btn btn-primary btn-block">Accept</button></div>';
			} else {
				echo 'error';
			}
		}
	} else {
		echo 'error';
	}
}

if ($_POST['request'] == 'accept_queue') {
	$rider_data = $app->getLogin();
	$rider_id = $rider_data['id'];
	$rider_details = find($rider_id, 'm_user');
	$queue_id = numhash($_POST['queue_id']);
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$queue_details = find($queue_id, 't_customer_queue');

	if (insert(['rider_id' => $rider_id, 'rider_loc_lat' => $latitude, 'rider_loc_lng' => $longitude], 't_rider_queue')) {
		$rider_queue = findDesc('t_rider_queue');
		if (update(['status_flg' => 1], 't_customer_queue', ['id' => $queue_id])) {
			if (insert(['customer_id' => $queue_details['customer_id'], 'rider_id' => $rider_id, 'customer_queue' => $queue_id, 'rider_queue' => $rider_queue['id']], 't_ride')) {
				echo "success";
			} else {
				print_r(getError());
			}
		} else {
			print_r(getError());
		}
	} else {
		print_r(getError());
	}
}