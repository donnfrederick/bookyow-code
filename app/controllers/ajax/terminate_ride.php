<?php

$app->checkXHR();

$regular_fare = findDesc('t_fare');

$regular_fare = $regular_fare['fare'];

if ($_POST['request'] == 'terminate') {
	if (isset($_POST['rider_queue_id']) && isset($_POST['customer_queue_id'])) {
		$ride = findBy('t_ride', ['rider_queue' => $_POST['rider_queue_id'], 'customer_queue' => $_POST['customer_queue_id'], 'status_flg' => 3]);
		$ride = $ride[0];
		$ride_id = $ride['id'];

		$payment_method = $req->post()->payment_method;
		$fare = $req->post()->fare;

		$customer_id = $ride['customer_id'];

		$customer_account = findBy('t_account', ['user_id' => $customer_id]);

		if (delete('t_rider_queue', $_POST['rider_queue_id'])) {
			if (delete('t_customer_queue', $_POST['customer_queue_id'])) {
				if (update(['status_flg' => 1], 't_ride', ['id' => $ride['id']])) {
					if ($payment_method == 1) {
						if ($customer_account) {
							$customer_account = $customer_account[0];
							if ($customer_account['account_balance'] >= $fare) {
								$account_balance = $customer_account['account_balance'];
								$new_account_balance = $account_balance - $fare;
								if (update(['account_balance' => $new_account_balance], 't_account', ['user_id' => $customer_id])) {
									if (insert(['user_id' => $customer_id, 'amount' => $fare, 'update_type' => 1, 'ride_id' => $ride_id], 't_transactions')) {
										echo json_encode(['result' => numhash($ride['id']), 'credited' => 1]);
									} else {
										echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
									}
								} else {
									echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
								}
							} else {
								echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
							}
						} else {
							echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
						}
					} else {
						echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
					}
				} else {
					echo json_encode(['result' => 'error']);
				}
			} else {
				echo json_encode(['result' => 'error']);
			}
		} else {
			echo json_encode(['result' => 'error']);
		}
	}
}

if ($_POST['request'] == 'check_termination') {
	if ($ride = findBy('t_ride', ['rider_queue' => $_POST['rider_queue_id'], 'customer_queue' => $_POST['customer_queue_id'], 'status_flg' => 1])) {
		$ride = $ride[0];
		$rider_id = $ride['rider_id'];

		$ride_id = $ride['id'];

		$ride_fare = findBy('t_ride_fare', ['ride_id' => $ride_id]);
		$fare = $ride_fare[0]['fare'];

		$customer_id = $ride['customer_id'];
		
		if (findBy('t_transactions', ['user_id' => $customer_id, 'update_type' => 1, 'ride_id' => $ride_id])) {
			if ($customer_account = findBy('t_account', ['user_id' => $rider_id])) {
				$account_balance = $customer_account[0]['account_balance'];
				$new_account_balance = $account_balance + $fare;
				if (update(['account_balance' => $new_account_balance], 't_account', ['user_id' => $rider_id])) {
					if (insert(['user_id' => $rider_id, 'amount' => $fare, 'update_type' => 0, 'ride_id' => $ride_id], 't_transactions')) {
						echo json_encode(['result' => numhash($ride['id']), 'credited' => 1]);
					} else {
						echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
					}
				} else {
					echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
				}
			} else {
				$new_account_balance = $fare;
				if (insert(['user_id' => $rider_id, 'account_balance' => $new_account_balance], 't_account')) {
					if (insert(['user_id' => $rider_id, 'amount' => $fare, 'update_type' => 0, 'ride_id' => $ride_id], 't_transactions')) {
						echo json_encode(['result' => numhash($ride['id']), 'credited' => 1]);
					} else {
						echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
					}
				} else {
					echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
				}
			}
		} else {
			echo json_encode(['result' => numhash($ride['id']), 'credited' => 0]);
		}
	} else {
		echo json_encode(['result' => 'continue']);
	}
}

?>