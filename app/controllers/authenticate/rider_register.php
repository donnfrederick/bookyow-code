<?php

if (isset($_POST['submit_form_register'])) {
	$error = null;

	$password = post('password');
	$confirm_password = post('confirm_password');

	$insert = array(
		'firstname' => post('firstname'),
		'lastname' => post('lastname'),
		'email' => post('email'),
		'phone_number' => post('phone_number'),
		'password' => password_hash($password, PASSWORD_BCRYPT),
		'account_type' => 1,
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
		setPostError($error);
	} else {
		if (!insert($insert, 'm_user')) {
			print_r(getPostError());
		} else {
			$app->redirectToRoute('/rider/register/success');
		}
	}
}