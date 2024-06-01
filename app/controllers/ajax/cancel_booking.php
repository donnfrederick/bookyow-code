<?php

$app->checkXHR();

$user_data = $app->getLogin();
$user_id = $user_data['id'];
$user_details = find($user_id, 'm_user');

if ($queue = findBy('t_customer_queue', ['customer_id' => $user_id])) {
	$queue = $queue[0];
	if (update(['delete_flg' => 1], 't_customer_queue', ['id' => $queue['id']])) {
		echo "success";
	} else {
		print_r(getError());
	}
}