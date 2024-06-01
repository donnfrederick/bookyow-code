<?php

if (!isset($req->get()->ride)) die();

$ride_id = numhash($req->get()->ride);
$ride_details = find($ride_id, 't_ride');

if ($ride_details['finished_flg'] == 1) {
	$app->appError('404');
}

?>