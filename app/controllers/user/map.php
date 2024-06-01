<?php

$login_details = $app->getLogin();

$user_id = $login_details['id'];

$queues = findByDesc('t_customer_queue', ['customer_id' => $user_id]);

$queues_count = count($queues);

$queue_lat = 0;
$queue_lng = 0;

if ($queues_count > 0) {
	$queue_lat = $queues[0]['customer_loc_lat'];
	$queue_lng = $queues[0]['customer_loc_lng'];
}

if (isset($_POST['form_book_button'])) {
	$insert = array(
		'customer_id' => $user_id,
		'customer_loc_lat' => $_POST['position_lat'],
		'customer_loc_lng' => $_POST['position_lng'],
		'desired_loc' => $_POST['complete_address'],
		'desired_loc_lat' => $_POST['address_lat'],
		'desired_loc_lng' => $_POST['address_lng']
	);

	if (!insert($insert, 't_customer_queue')) {
		die('Unable to insert into queue');
	}

	header("Refresh:0");
}

$on_ride = 0;
$on_ride_2 = 0;
$has_ping = 0;

if (findBy('t_ride', ['customer_id' => $user_id, 'status_flg' => 2])) {
	$on_ride = 1;
}

if ($on_ride) {
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

	$ride_init_locations = json_encode($locations);

	$rider_details = find($rider_queue['rider_id'], 'm_user');

	$rider_ratings = 0;

	$rider_ratings_score = 0;
	$rider_ratings_count = 0;

	foreach (findBy('t_ratings', ['rider_id' => $rider_details['id']]) as $rating) {
		$rider_ratings_score += $rating['rating'];
		$rider_ratings_count += 1;
	}

	if ($rider_ratings_score > 0) {
		$rider_ratings = getAve($rider_ratings_score, $rider_ratings_count);
	}

	$vehicle_info = findBy('t_vehicle_info', ['rider_id' => $rider_details['id']]);
	$vehicle_info = $vehicle_info[0];

	$new_ride_details = json_encode(['ride_id' => $ride_details['id'], 'rider_queue' => $rider_queue['id'], 'user_queue' => $user_queue['id']]);

	if (findBy('t_ping', ['ride_id' => $ride_details['id'], 'customer' => 1])) {
		$has_ping = 1;
	}
}

if ($ride = findBy('t_ride', ['customer_id' => $user_id, 'status_flg' => 3])) {
	$ride = $ride[0];
	$on_ride_2 = 1;

	$new_rider_queue = find($ride['rider_queue'], 't_rider_queue');

	$rider_queue = json_encode($new_rider_queue);

	$user_queue = find($ride['customer_queue'], 't_customer_queue');

	$customer_queue = json_encode($user_queue);

	$new_ride_details = findBy('t_ride', ['customer_queue' => $user_queue['id'], 'rider_queue' => $new_rider_queue['id']]);

	$ride_details = json_encode($new_ride_details[0]);

	$rider_details = find($new_rider_queue['rider_id'], 'm_user');

	$vehicle_info = findBy('t_vehicle_info', ['rider_id' => $rider_details['id']]);
	$vehicle_info = $vehicle_info[0];

	$rider_ratings = 0;

	$rider_ratings_score = 0;
	$rider_ratings_count = 0;

	foreach (findBy('t_ratings', ['rider_id' => $rider_details['id']]) as $rating) {
		$rider_ratings_score += $rating['rating'];
		$rider_ratings_count += 1;
	}

	if ($rider_ratings_score > 0) {
		$rider_ratings = getAve($rider_ratings_score, $rider_ratings_count);
	}
}

$account_balance = '0.00';

if (findByDesc('t_account', ['user_id' => $user_id])) {
	$account_balance = findByDesc('t_account', ['user_id' => $user_id]);
	$account_balance = $account_balance[0]['account_balance'];
}


?>