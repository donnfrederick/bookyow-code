<?php
	session_destroy();
	$login_details = $app->getLogin();
	if ($login_details['type'] == 1) {
		$app->redirectToRoute('/login');
	} elseif ($login_details['type'] == 2) {
		$app->redirectToRoute('/rider/login');
	} else {
		$app->redirectToRoute('/admin/login');
	}
	unset($_SESSION['login']);
?>