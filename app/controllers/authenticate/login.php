<?php

error_reporting(E_ALL & ~E_NOTICE);

if (!is_null($login_session = $app->getLogin())) {
	if ($login_session['type'] == 1) {
		$app->redirectToRoute('/');
	}
}