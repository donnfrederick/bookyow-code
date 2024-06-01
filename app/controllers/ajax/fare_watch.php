<?php

$app->checkXHR();

if ($req->post()->request == 'watch') {
	$ride_id = $req->post()->ride_id;

	if (findBy('t_ride_fare', ['ride_id' => $ride_id])) {
		echo json_encode(['result' => 'success', 'value' => 'completed']);
	} else {
		echo json_encode(['result' => 'success', 'value' => 'not_found']);
	}
}

if ($req->post()->request == 'add') {
	$ride_id = $req->post()->ride_id;
	$fare_price = $req->post()->fare_price;

	if (insert(['ride_id' => $ride_id, 'fare' => $fare_price], 't_ride_fare')) {
		echo json_encode(['result' => 'success']);
	} else {
		echo json_encode(['result' => 'error', 'error' => getError()]);
	}
}

if ($req->post()->request == 'get') {
	if (findBy('t_ride_fare', ['ride_id' => $req->post()->ride_id])) {
		$ride_fare = findBy('t_ride_fare', ['ride_id' => $req->post()->ride_id]);
		echo json_encode(['result' => 'success', 'value' => $ride_fare[0]['fare']]);	
	} else {
		echo json_encode(['result' => 'error', 'error' => getError()]);
	}
}

?>