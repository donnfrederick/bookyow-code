<?php

$app->checkXHR();

if ($_POST['request'] == 'rider') {
	$has_error = 0;

	$rider_data = $app->getLogin();
	$rider_id = $rider_data['id'];

	$rider_queue = findBy('t_rider_queue', ['rider_id' => $rider_id]);
	$rider_queue = $rider_queue[0];

	$ride_data = findBy('t_ride', ['status_flg' => 2, 'rider_id' => $rider_id]);
	$ride_details = $ride_data[0];

	$customer_queue_id = $ride_details['customer_queue'];

	$user_queue = find($customer_queue_id, 't_customer_queue');

	$locations = array(
		'u_lat' => null,
		'u_lng' => null,
		'r_lat' => null,
		'r_lng' => null
	);

	foreach ($locations as $location) {
		if ($location == null) {
			$has_error += 1;
		}
	}

	if ($has_error > 0) {
		echo "error";
	} else {
		echo "success";
	}
}

if ($_POST['request'] == 'user') {
	$has_error = 0;

	$user_data = $app->getLogin();
	$user_id = $user_data['id'];

	$user_queue = findBy('t_customer_queue', ['customer_id' => $user_id, 'status_flg' => 1]);
	$user_queue = $user_queue[0];

	$ride_data = findBy('t_ride', ['status_flg' => 2, 'customer_id' => $user_id]);
	$ride_details = $ride_data[0];

	$rider_queue_id = $ride_details['rider_queue'];

	$rider_queue = find($rider_queue_id, 't_rider_queue');

	$locations = array(
		'u_lat' => $user_queue['customer_loc_lat'],
		'u_lng' => $user_queue['customer_loc_lng'],
		'r_lat' => $rider_queue['rider_loc_lat'],
		'r_lng' => $rider_queue['rider_loc_lng']
	);

	foreach ($locations as $location) {
		if ($location == null) {
			$has_error += 1;
		}
	}

	if ($has_error > 0) {
		echo "error";
	} else {
		echo json_encode($locations);
	}
}

?>