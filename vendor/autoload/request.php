<?php

/*
	Author: June Bella
	Title: Web Developer
*/

namespace App\Config\Controller;

class RequestController {
	public function post() {
		return (object) $_POST;
	}

	public function get() {
		return (object) $_GET;
	}

	public function session() {
		return (object) $_SESSION;
	}

	public function file() {
		return (object) $_FILES;
	}
	
	public function cookie() {
		return (object) $_COOKIE;
	}
}