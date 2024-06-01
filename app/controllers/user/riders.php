<?php

$riders = findBy('t_fav', ['customer_id' => $app->userData()->id]);

function riderDetails($rider_id) {
	return (object) find($rider_id, 'm_user');
}

function riderRatings($rider_id) {
	$rider_ratings = 0;

	$rider_ratings_score = 0;
	$rider_ratings_count = 0;

	foreach (findBy('t_ratings', ['rider_id' => $rider_id]) as $rating) {
		$rider_ratings_score += $rating['rating'];
		$rider_ratings_count += 1;
	}

	if ($rider_ratings_score > 0) {
		$rider_ratings = getAve($rider_ratings_score, $rider_ratings_count);
	}

	return $rider_ratings;
}

?>