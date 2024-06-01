<?php

$on_ride = 0;
$on_ride_2 = 0;
$has_ping = 0;

$ride_details = json_encode([]);

$rider_data = $app->getLogin();
$rider_id = $rider_data['id'];
$rider_details = find($rider_id, 'm_user');

if (findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 0]) || findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 2])) {
	$on_ride = 1;
}

if ($on_ride) {
	$rider_queue = findBy('t_rider_queue', ['rider_id' => $rider_id]);
	$rider_queue = $rider_queue[0];

	$ride_data = findByDesc('t_ride', ['rider_id' => $rider_id]);
	$ride_details = $ride_data[0];

	$customer_queue_id = $ride_details['customer_queue'];

	$user_queue = find($customer_queue_id, 't_customer_queue');

	$locations = array(
		'u_lat' => $user_queue['customer_loc_lat'],
		'u_lng' => $user_queue['customer_loc_lng'],
		'r_lat' => $rider_queue['rider_loc_lat'],
		'r_lng' => $rider_queue['rider_loc_lng']
	);

	$ride_init_locations = json_encode($locations);

	$user_details = find($user_queue['customer_id'], 'm_user');

	$new_ride_details = json_encode(['ride_id' => $ride_details['id'], 'rider_queue' => $rider_queue['id'], 'user_queue' => $customer_queue_id]);

	if (findBy('t_ping', ['ride_id' => $ride_details['id'], 'rider' => 1])) {
		$has_ping = 1;
	}

	$ride_details = $new_ride_details;
}

if (findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 3])) {
	$on_ride_2 = 1;

	$new_rider_queue = findByDesc('t_rider_queue', ['rider_id' => $rider_id]);
	$rider_queue = json_encode($new_rider_queue[0]);

	$ride = findBy('t_ride', ['rider_id' => $rider_id, 'status_flg' => 3]);
	$ride = $ride[0];

	$user_queue = find($ride['customer_queue'], 't_customer_queue');

	$customer_queue = json_encode($user_queue);

	$user_details = find($user_queue['customer_id'], 'm_user');

	$new_ride_details = findBy('t_ride', ['customer_queue' => $user_queue['id'], 'rider_queue' => $new_rider_queue[0]['id']]);
	$ride_details = json_encode($new_ride_details[0]);
}

?>