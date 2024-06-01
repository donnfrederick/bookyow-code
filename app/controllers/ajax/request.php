<?php

$app->checkXHR();

if (is_null($request = post('request'))) die('Invalid request');

if ($request == 'user_login') {
	if (exist('email', post('username'), 'm_user')) {
		$user_details = findBy('m_user', ['email' => post('username'), 'account_type' => 0]);

		if (count($user_details) > 0) {
			if (password_verify(post('password'), $user_details[0]['password'])) {
				$user_details[0]['type'] = 1;
				$app->setLogin($user_details);
				echo "success";
			} else {
				echo "Please check username and password";
			}
		} else {
			echo "Please check username and password";
		}
	} else {
		echo "Please check username and password";
	}
}

if ($request == 'user_register') {
	$error = null;

	$password = post('password');
	$confirm_password = post('confirm_password');

	$insert = array(
		'firstname' => post('firstname'),
		'lastname' => post('lastname'),
		'email' => post('email'),
		'phone_number' => post('phone_number'),
		'password' => password_hash($password, PASSWORD_BCRYPT),
		'image_name' => ''
	);

	if (exist('email', post('email'), 'm_user')) {
		$error = "Email already used";
	}

	if (exist('phone_number', post('phone_number'), 'm_user')) {
		$error = "Phone number already used";
	}

	if ($password != $confirm_password) {
		$error = "Password does not match";
	}

	if (findBy('m_user', ['firstname' => post('firstname'), 'lastname' => post('lastname')])) {
		$error = "Your information already exist";
	}

	if ($error != null) {
		echo $error;
	} else {
		if (insert($insert, 'm_user')) {
			echo "success";
		} else {
			print_r(getError());
		}
	}
}

if ($request == 'delete_general') {
	$id = $req->post()->id;
	$table = $req->post()->table;

	if ($table == 'user') {
		$table = 'm_user';
	} else {
		$table = 't_'.$table;
	}

	if ($id != 0 AND $table != '') {
		if (update(['delete_flg' => 1], $table, ['id' => $id])) {
			echo "success";
		} else {
			echo "Error";
		}
	}
}

?>