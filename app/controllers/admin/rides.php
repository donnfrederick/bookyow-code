<?php

$rides = findByDesc('t_ride', ['finished_flg' => 1]);

function getLocationDesired($queue_id) {
	$db = new DB();

	$query = "SELECT desired_loc
			  FROM t_customer_queue
			  WHERE id = $queue_id;";

	$result = $db->execute($query);

	return $result[0];
}

?>