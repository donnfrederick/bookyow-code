<?php

$app->checkXHR();

$user_data = $app->getLogin();
$user_id = $user_data['id'];
$user_details = find($user_id, 'm_user');

if ($_POST['request'] == 'check_ride') {
	if (findBy('t_ride', ['customer_id' => $user_id, 'status_flg' => 0])) {
		echo "success";
	} elseif (findBy('t_ride', ['customer_id' => $user_id, 'status_flg' => 2])) {
		echo "stop";
	} elseif (findBy('t_ride', ['customer_id' => $user_id, 'status_flg' => 3])) {
		echo "stop";
	} else {
		print_r(getError());
	}
}

if ($_POST['request'] == 'accept_queue') {
	$queue = findBy('t_ride', ['customer_id' => $user_id, 'status_flg' => 0]);

	if (update(['status_flg' => 2], 't_ride', ['id' => $queue[0]['id']])) {
		echo 'success';
	} else {
		print_r(getError());
	}
}