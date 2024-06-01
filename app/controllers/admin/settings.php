<?php

$login_details = $app->getLogin();

$admin_details = find($login_details['id'], 'm_admin');

$runtime_mode = findDesc('t_runtime_mode');

$fare = findDesc('t_fare');

if (isset($req->post()->change_password)) {
	update(['password' => password_hash($req->post()->confirm_pass, PASSWORD_BCRYPT)], 'm_admin', ['id' => $login_details['id']]);
	$app->clearLogin();
	header("Location: /admin/login");
}

if (isset($req->post()->save_changes)) {
	$name = $req->post()->name;
	$username = $req->post()->username;

	update(['name' => $name, 'username' => $username], 'm_admin', ['id' => $login_details['id']]);

	update(['fare' => $req->post()->fare], 't_fare', ['id' => 1]);

	update(['mode' => $req->post()->runtime], 't_runtime_mode', ['id' => 1]);

	header("Refresh: 0");
}

?>