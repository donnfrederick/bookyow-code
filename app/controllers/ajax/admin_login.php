<?php

$app->checkXHR();

if (isset($req->post()->username) && isset($req->post()->password)) {
	if ($admin_details = findBy('m_admin', ['username' => $req->post()->username])) {
		if (password_verify($req->post()->password, $admin_details[0]['password'])) {
			$admin_details[0]['type'] = 3;
			$app->setLogin($admin_details);
			echo json_encode(['result' => 'success']);
		} else {
			echo json_encode(['result' => 'error', 'error' => 'Invalid username or password']);
		}
	} else {
		echo json_encode(['result' => 'error', 'error' => 'Invalid username or password']);
	}
}

?>