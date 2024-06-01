<?php

$users = findByDesc('m_user', ['account_type' => 0]);
$riders = findByDesc('m_user', ['account_type' => 1]);
$rides = findByDesc('t_ride', ['finished_flg' => 1]);

function getLocationDesired($queue_id) {
	$db = new DB();

	$query = "SELECT desired_loc
			  FROM t_customer_queue
			  WHERE id = $queue_id;";

	$result = $db->execute($query);

	return $result[0];
}

$verification_reqs = findByDesc('t_vehicle_info', ['verified_flg' => 0]);

?>