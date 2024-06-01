<?php

$funds_requests = findAllDesc('t_fund_request');

// If request is approved
if (isset($req->post()->submit_fund_request_approve)) {
	$user_id = $req->post()->user_id;

	// If has an existing deposits
	if (findBy('t_account', ['user_id' => $user_id])) {
		$account = findBy('t_account', ['user_id' => $user_id]);

		$account_details = $account[0];
		$account_id = $account_details['id'];
		$funds = $account_details['account_balance'];

		$funds_update = $funds + $req->post()->amount;

		// Update query
		if (!update(['account_balance' => $funds_update], 't_account', ['id' => $account_id])) {
			die('Unable to update account');
		}
	} else { // If no existing deposits
		if (!insert(['user_id' => $user_id, 'account_balance' => $req->post()->amount], 't_account')) { // Insert query
			die('Unable to create account');
		}
	}

	// Deleting requests from table
	if (!delete('t_fund_request', $req->post()->request_id)) {
		die('An error occured');
	}

	// Refresh if has no error
	header("Refresh: 0");
}

// If fund request is denied
if (isset($req->post()->submit_fund_request_deny)) {
	// Remove from request table
	if (!delete('t_fund_request', $req->post()->request_id)) {
		die('An error occured');
	}

	// Refresh if has no error
	header("Refresh: 0");
}

?>