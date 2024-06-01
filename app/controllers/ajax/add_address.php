<?php

$app->checkXHR();

if (insert(array(
	'user_id' => $app->loginData()->id,
	'address_type' => numhash($req->post()->address_type),
	'address_house' => $req->post()->address_house,
	'address_barangay' => $req->post()->address_barangay,
	'address_municipality' => $req->post()->address_municipality,
	'address_province' => $req->post()->address_province,
	'address_zip' => $req->post()->address_zip
), 't_addresses')) {
	echo json_encode(['result' => 'success']);
} else {
	echo json_encode(['result' => 'error', 'error' => getError()]);
}

?>