<?php

$verification_reqs = findByDesc('t_vehicle_info', ['verified_flg' => 0]);

function getRiderUploads($rider_id, $vehicle_or_id, $vehicle_cr_id, $vehicle_id, $vehicle_color, $vehicle_plate_number, $verification_req_id) {
	$uploads_data = [];

	$license_data = findByDesc('t_uploads', ['user_id' => $rider_id, 'file_type' => 1]);
	$uploads_data['license'] = $license_data[0]['file'];

	$selfie_data = findByDesc('t_uploads', ['user_id' => $rider_id, 'file_type' => 2]);
	$uploads_data['selfie'] = $selfie_data[0]['file'];

	$vehicle_or_data = descFind($vehicle_or_id, 't_uploads');
	$uploads_data['vehicle_or'] = $vehicle_or_data['file'];

	$vehicle_cr_data = descFind($vehicle_cr_id, 't_uploads');
	$uploads_data['vehicle_cr'] = $vehicle_cr_data['file'];

	$vehicle_data = descFind($vehicle_id, 't_uploads');
	$uploads_data['vehicle'] = $vehicle_data['file'];

	$uploads_data['color'] = $vehicle_color;

	$uploads_data['plate_number'] = $vehicle_plate_number;

	$uploads_data['verification_req_id'] = numhash($verification_req_id);

	return json_encode($uploads_data);
}

if (isset($req->post()->approve)) {
	update(['verified_flg' => 1], 't_vehicle_info', ['id' => numhash($req->post()->verification_req_id)]);
	header("Refresh: 0");
}

if (isset($req->post()->decline)) {
	update(['verified_flg' => 2], 't_vehicle_info', ['id' => numhash($req->post()->verification_req_id)]);
	header("Refresh: 0");
}

?>