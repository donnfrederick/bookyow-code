<?php

$app->checkXHR();

foreach (findBy('t_addresses', ['user_id' => $app->loginData()->id]) as $address) {
	if (!update(['default_flg' => 0], 't_addresses', ['id' => $address['id']])) {
		die();
	}
}

$address_id = numhash($req->post()->address_id);

if (update(['default_flg' => 1], 't_addresses', ['id' => $address_id])) {
	echo json_encode(['result' => 'success']);
} else {
	echo json_encode(['result' => 'error', 'error' => getError()]);
}

?>