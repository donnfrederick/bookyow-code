<?php

$riders = findByDesc('m_user', ['account_type' => 1]);

if (isset($req->post()->update_user)) {
	$user_id = numhash($req->post()->req_id);

	$update = array(
		'lastname' => $req->post()->lastname,
		'firstname' => $req->post()->firstname,
		'email' => $req->post()->email,
		'phone_number' => $req->post()->phone_number
	);

	if ($req->post()->new_pass != '' || $req->post()->confirm_pass != '') {
		if ($req->post()->new_pass == $req->post()->confirm_pass) {
			if (strlen($req->post()->new_pass) <= 6) {
				die('An error occured');
			} else {
				$update['password'] = password_hash($req->post()->new_pass, PASSWORD_BCRYPT);
			}
		} else {
			die('An error occured');
		}
	}

	if (!update($update, 'm_user', ['id' => $user_id])) {
		die('An error occured');
	} else {
		header("Refresh: 0");
	}
}

?>