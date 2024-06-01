<?php

$user_id = $app->userData()->id;

$account = findByDesc('t_account', ['user_id' => $user_id]);

if ($account) {
	$account_id = $account[0]['id'];
}

if ($account) {
	$funds = addZeroes($account[0]['account_balance']);
	$real_funds = $account[0]['account_balance'];
} else {
	$funds = addZeroes(0);
	$real_funds = 0;
}

$accounts = findByDesc('t_accounts', ['user_id' => $user_id]);

function getAccountType($bank_type) {
	if ($bank_type == 1) {
		return 'bdo.jpg';
	} elseif ($bank_type == 2) {
		return 'bpi.jpg';
	} elseif ($bank_type == 3) {
		return 'ub.jpg';
	} elseif ($bank_type == 4) {
		return 'rcbc.png';
	}
}

if (isset($req->post()->add_account)) {
	$bank_type = $req->post()->bank_type;
	
	if (!insert(['user_id' => $user_id, 'account_name' => $req->post()->account_name, 'account_number' => $req->post()->account_number, 'bank_type' => $bank_type[0]], 't_accounts')) {
		print_r(getError());
	} else {
		header("Refresh: 0");
	}
}

if (isset($req->post()->cashout)) {
	if ($funds >= $req->post()->cashout_amount) {
		if (!insert(['user_id' => $user_id, 'amount' => $req->post()->cashout_amount, 'update_type' => 1, 'account' => $req->post()->cashout_account], 't_transactions')) {
			print_r(getError());
		} else {
			if (!update(['account_balance' => $funds - $req->post()->cashout_amount], 't_account', ['id' => $account_id])) {
				print_r(getError());
			} else {
				header("Location: /rider");
			}
		}
	} else {
		die('Insufficient balance');
	}
}

?>