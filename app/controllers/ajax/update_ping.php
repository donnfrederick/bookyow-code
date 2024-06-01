<?php

$app->checkXHR();

$ride_id = $_POST['ride_id'];

if ($_POST['request'] == 'update_user_ping') {
	if ($ping = findBy('t_ping', ['ride_id' => $ride_id])) {
		if (update(['customer' => 1], 't_ping', ['id' => $ping[0]['id']])) {
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
		}
	} else {
		if (insert(['ride_id' => $ride_id, 'customer' => 1], 't_ping')) {
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
		}
	}
}

if ($_POST['request'] == 'update_rider_ping') {
	if ($ping = findBy('t_ping', ['ride_id' => $ride_id])) {
		if (update(['rider' => 1], 't_ping', ['id' => $ping[0]['id']])) {
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
		}
	} else {
		if (insert(['ride_id' => $ride_id, 'rider' => 1], 't_ping')) {
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
		}
	}
}

if ($_POST['request'] == 'update_ping') {
	if (findBy('t_ping', ['ride_id' => $ride_id, 'customer' => 1, 'rider' => 1])) {
		if (update(['status_flg' => 3], 't_ride', ['id' => $ride_id])) {
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
		}
	} else {
		echo json_encode(['result' => 'empty']);
	}
}

?>