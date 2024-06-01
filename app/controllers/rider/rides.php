<?php

$login_details = $app->getLogin();

$user_id = $login_details['id'];

$rides = findByDesc('t_ride', ['rider_id' => $user_id]);

function checkCredit($ride_id) {
	if (findBy('t_transactions', ['ride_id' => $ride_id])) {
		return 1;
	} else {
		return 0;
	}
}

function getLocationDesired($queue_id) {
	$db = new DB();

	$query = "SELECT desired_loc
			  FROM t_customer_queue
			  WHERE id = $queue_id;";

	$result = $db->execute($query);

	return $result[0];
}

?>