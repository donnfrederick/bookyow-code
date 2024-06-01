<?php

$app->checkXHR();

$user_lat = 0;
$user_lng = 0;
$rider_lat = 0;
$rider_lng = 0;

if ($req->post()->request == 'get_points') {
	if (isset($_POST['rider_queue_id']) || isset($_POST['customer_queue_id'])) {
		if ($user_queue = find($_POST['customer_queue_id'], 't_customer_queue')) {
			$user_lat = $user_queue['customer_loc_lat'];
			$user_lng = $user_queue['customer_loc_lng'];
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
			die();
		}

		if ($rider_queue = find($_POST['rider_queue_id'], 't_rider_queue')) {
			$rider_lat = $rider_queue['rider_loc_lat'];
			$rider_lng = $rider_queue['rider_loc_lng'];
		} else {
			echo json_encode(['result' => 'error', 'error' => getError()]);
			die();
		}

		echo json_encode(['result' => array(
			'user_lat' => $user_lat,
			'user_lng' => $user_lng,
			'rider_lat' => $rider_lat,
			'rider_lng' => $rider_lng
		)]);
	} else {
		echo json_encode(['result' => 'error', 'error' => 'Empty Data']);
		die();
	}
}

if ($req->post()->request == 'get_points_update_rider') {
	if (update(['rider_loc_lat' => $req->post()->new_lat, 'rider_loc_lng' => $req->post()->new_lng], 't_rider_queue', ['id' => $req->post()->rider_queue_id])) {
		if (isset($_POST['rider_queue_id']) || isset($_POST['customer_queue_id'])) {
			if ($user_queue = find($_POST['customer_queue_id'], 't_customer_queue')) {
				$user_lat = $user_queue['customer_loc_lat'];
				$user_lng = $user_queue['customer_loc_lng'];
			} else {
				echo json_encode(['result' => 'error', 'error' => getError()]);
				die();
			}

			if ($rider_queue = find($_POST['rider_queue_id'], 't_rider_queue')) {
				$rider_lat = $rider_queue['rider_loc_lat'];
				$rider_lng = $rider_queue['rider_loc_lng'];
			} else {
				echo json_encode(['result' => 'error', 'error' => getError()]);
				die();
			}

			echo json_encode(['result' => array(
				'user_lat' => $user_lat,
				'user_lng' => $user_lng,
				'rider_lat' => $rider_lat,
				'rider_lng' => $rider_lng
			)]);
		} else {
			echo json_encode(['result' => 'error', 'error' => 'Empty Data']);
			die();
		}
	} else {
		die();
	}
}

if ($req->post()->request == 'get_points_update_customer') {
	if (update(['customer_loc_lat' => $req->post()->new_lat, 'customer_loc_lng' => $req->post()->new_lng], 't_customer_queue', ['id' => $req->post()->customer_queue_id])) {
		if (isset($_POST['rider_queue_id']) || isset($_POST['customer_queue_id'])) {
			if ($user_queue = find($_POST['customer_queue_id'], 't_customer_queue')) {
				$user_lat = $user_queue['customer_loc_lat'];
				$user_lng = $user_queue['customer_loc_lng'];
			} else {
				echo json_encode(['result' => 'error', 'error' => getError()]);
				die();
			}

			if ($rider_queue = find($_POST['rider_queue_id'], 't_rider_queue')) {
				$rider_lat = $rider_queue['rider_loc_lat'];
				$rider_lng = $rider_queue['rider_loc_lng'];
			} else {
				echo json_encode(['result' => 'error', 'error' => getError()]);
				die();
			}

			echo json_encode(['result' => array(
				'user_lat' => $user_lat,
				'user_lng' => $user_lng,
				'rider_lat' => $rider_lat,
				'rider_lng' => $rider_lng
			)]);
		} else {
			echo json_encode(['result' => 'error', 'error' => 'Empty Data']);
			die();
		}
	} else {
		die();
	}
}

?>