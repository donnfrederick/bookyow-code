<?php

$error = null;

$user_id = $app->userData()->id;

if (isset($req->post()->submit_verification)) {
	$verification_reqs = [];
	$verification_reqs['license'] = $req->file()->license;
	$verification_reqs['selfie'] = $req->file()->selfie;
	$verification_reqs['vehicle_or'] = $req->file()->vehicle_or;
	$verification_reqs['vehicle_cr'] = $req->file()->vehicle_cr;
	$verification_reqs['vehicle'] = $req->file()->vehicle;

	$verification_reqs_name = [];

	$err = getError();

	foreach ($verification_reqs as $requirement => $requirement_value) {
		$image = (object) $requirement_value;

		$file_name = $image->name;
		$file_name_arr = explode('.', $file_name);
		$file_type = end($file_name_arr);

		$new_file_name = md5(date("YmdHis$file_name"));

		

		if (!in_array($file_type, ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'])) {
			array_push($err, 'Invalid file type');
		} else {
			if (!move_uploaded_file($image->tmp_name, $htmlDirectory.'/imgs/'.$new_file_name.'.'.$file_type)) {
				array_push($err, 'Unable to move image');
			} else {
				$verification_reqs_name[$requirement] = $new_file_name.'.'.$file_type;
			}
		}
	}

	$vehicel_info = ['rider_id' => $user_id, 'color' => $req->post()->color, 'plate_number' => $req->post()->plate_number];

	foreach ($verification_reqs_name as $requirement => $file_name) {
		if ($requirement == 'license') {
			if (!insert(['user_id' => $user_id, 'file' => $file_name, 'file_type' => 1], 't_uploads')) {
				array_push($err, 'Unable to insert license');
			}
		}

		if ($requirement == 'selfie') {
			if (!insert(['user_id' => $user_id, 'file' => $file_name, 'file_type' => 2], 't_uploads')) {
				array_push($err, 'Unable to insert selfie');
			}
		}

		if ($requirement == 'vehicle_or' || $requirement == 'vehicle_cr' || $requirement == 'vehicle') {
			if (insert(['user_id' => $user_id, 'file' => $file_name, 'file_type' => 3], 't_uploads')) {
				$upload_details = findDesc('t_uploads');
				$vehicel_info[$requirement] = $upload_details['id'];
			} else {
				array_push($err, 'Unable to insert selfie');
			}
		}
	}

	if (!insert($vehicel_info, 't_vehicle_info')) {
		array_push($err, 'Unable to vehicle info');
	}

	$error = getError();

	if ($error == null) {
		header("Location: /rider");
	}

	// print_r($verification_reqs);
}

if ($error != null) {
	print_r($error);
}

$is_verified = 0;

if (findBy('t_vehicle_info', ['verified_flg' => 1, 'rider_id' => $user_id])) {
	$is_verified = 1;
}

$queue_verification = 0;

if (findBy('t_vehicle_info', ['verified_flg' => 0, 'rider_id' => $user_id])) {
	$queue_verification = 1;
}

?>