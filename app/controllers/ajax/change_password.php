<?php

$app->checkXHR();

$user_id = $app->userData()->id;

if ($req->post()->confirm_pass == $req->post()->new_pass) {
	if (password_verify($req->post()->old_pass, $app->userData()->password)) {
		$new_password = password_hash($req->post()->confirm_pass, PASSWORD_BCRYPT);
		if (update(['password' => $new_password], 'm_user', ['id' => $user_id])) {
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => 'Unable to update password']);
		}
	} else {
		echo json_encode(['result' => 'error', 'error' => 'Invalid password']);
	}
} else {
	echo json_encode(['result' => 'error', 'error' => 'Password does not match']);
}

?>