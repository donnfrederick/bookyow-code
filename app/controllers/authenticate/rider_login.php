<?php

if (isset($_POST['submit_form_login'])) {
	$error = null;

	if (exist('email', post('user'), 'm_user')) {
		$user_details = findBy('m_user', ['email' => post('user'), 'account_type' => 1]);
		
		if (count($user_details) > 0) {
			if (password_verify(post('password'), $user_details[0]['password'])) {
				$user_details[0]['type'] = 2;
				$app->setLogin($user_details);
				$app->redirectToRoute('/rider');
			} else {
				$error = "Please check username and password";
			}
		} else {
			$error = "Please check username and password";
		}
	} else {
		$error = "Please check username and password";
	}

	if ($error != null) {
		setPostError($error);
	}
}