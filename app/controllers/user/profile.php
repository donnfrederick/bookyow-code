<?php

$user_id = $app->userData()->id;

$error = null;

if (isset($req->post()->change_name)) {
	if (!update(['firstname' => $req->post()->firstname, 'lastname' => $req->post()->lastname], 'm_user', ['id' => $user_id])) {
		$error = getError();
	}

	if ($error == null) {
		header("Refresh: 0");
	}
}

if (isset($req->post()->change_number)) {
	if (!update(['phone_number' => $req->post()->phone_number], 'm_user', ['id' => $user_id])) {
		$error = getError();
	}

	if ($error == null) {
		header("Refresh: 0");
	}
}

if (isset($req->post()->change_image)) {
	$image = (object) $req->file()->image;

	$file_name = $image->name;
	$file_name_arr = explode('.', $file_name);
	$file_type = end($file_name_arr);

	$new_file_name = md5(date('YmdHis'));

	$err = getError();

	if (!in_array($file_type, ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'])) {
		array_push($err, 'Invalid file type');
	} else {
		if (!insert(['user_id' => $user_id, 'file' => $new_file_name.'.'.$file_type], 't_uploads')) {
			array_push($err, 'Unable to insert image');
		} else {
			$new_image_uploaded = (object) findDesc('t_uploads');
			if (!update(['image_id' => $new_image_uploaded->id, 'image_name' => $file_name], 'm_user', ['id' => $user_id])) {
				array_push($err, 'Unable to update user data');
			} else {
				if (!move_uploaded_file($image->tmp_name, $htmlDirectory.'/imgs/'.$new_file_name.'.'.$file_type)) {
					array_push($err, 'Unable to move image');
				}
			}
		}
	}

	$error = getError();

	if ($error == null) {
		header("Refresh: 0");
	}
}

if (isset($req->post()->change_email)) {
	if (!update(['email' => $req->post()->email], 'm_user', ['id' => $user_id])) {
		$error = getError();
	}

	if ($error == null) {
		header("Refresh: 0");
	}
}

if ($error != null) {
	print_r($error);
}

?>