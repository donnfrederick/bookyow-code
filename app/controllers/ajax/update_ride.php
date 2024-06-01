<?php

$app->checkXHR();

$rider_lat = 0;
$rider_lng = 0;

if ($_POST['request'] == 'get_location') {
	if (isset($_POST['rider_queue_id'])) {
		if ($rider_queue = find($_POST['rider_queue_id'], 't_rider_queue')) {
			$rider_lat = $rider_queue['rider_loc_lat'];
			$rider_lng = $rider_queue['rider_loc_lng'];
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
			die();
		}

		echo json_encode(['result' => array(
			'rider_lat' => $rider_lat,
			'rider_lng' => $rider_lng
		)]);
	} else {
		echo json_encode(['result' => 'error', 'error' => 'Empty Data']);
		die();
	}
}

if ($_POST['request'] == 'update_points') {
	if (isset($_POST['rider_queue_id'])) {
		$new_lat = $_POST['new_lat'];
		$new_lng = $_POST['new_lng'];
		$rider_queue_id = $_POST['rider_queue_id'];
		if (update(['rider_loc_lat' => $new_lat, 'rider_loc_lng' => $new_lng], 't_rider_queue', ['id' => $rider_queue_id])) {
			echo json_encode(['result' => 'sucess']);
		} else {
			echo json_encode(['result' => 'error', 'error' => 'Empty Data']);
			die();
		}
	} else {
		echo json_encode(['result' => 'error', 'error' => 'Empty Data']);
		die();
	}
}

?>