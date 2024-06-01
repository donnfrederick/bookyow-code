<?php

$app->checkXHR();

$customer_id = numhash($req->post()->customer_id);
$rider_id = numhash($req->post()->rider_id);
$ride_id = numhash($req->post()->ride_id);
$rate_rating = $req->post()->rate_rating;
$rate_comment = $req->post()->rate_comment;
$add_fav = $req->post()->add_fav;

if ($rate_comment != '' && $rate_rating != 0) {
	$insert = array(
		'ride_id' => $ride_id,
		'rider_id' => $rider_id,
		'customer_id' => $customer_id,
		'rating' => $rate_rating,
		'comment' => $rate_comment
	);

	if (!insert($insert, 't_ratings')) {
		echo json_encode(['result' => 'error', 'error' => ['customer_id' => $customer_id, 'rider_id' => $rider_id, 'ride_id' => $ride_id, 'rate_rating' => $rate_rating, 'rate_comment' => $rate_comment, 'add_fav' => $add_fav, 'remarks' => getError()]]);
		die();
	}
}

if ($add_fav != 0) {
	if (!findBy('t_fav', ['customer_id' => $customer_id, 'rider_id' => $rider_id])) {
		if (!insert(['customer_id' => $customer_id, 'rider_id' => $rider_id], 't_fav')) {
			echo json_encode(['result' => 'error', 'error' => ['customer_id' => $customer_id, 'rider_id' => $rider_id, 'ride_id' => $ride_id, 'rate_rating' => $rate_rating, 'rate_comment' => $rate_comment, 'add_fav' => $add_fav, 'remarks' => getError()]]);
			die();
		}
	}
}

if (!update(['finished_flg' => 1], 't_ride', ['id' => $ride_id])) {
	echo json_encode(['result' => 'error', 'error' => ['customer_id' => $customer_id, 'rider_id' => $rider_id, 'ride_id' => $ride_id, 'rate_rating' => $rate_rating, 'rate_comment' => $rate_comment, 'add_fav' => $add_fav, 'remarks' => getError()]]);
	die();
}

echo json_encode(['result' => 'success']);



?>