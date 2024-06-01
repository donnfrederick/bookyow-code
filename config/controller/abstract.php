<?php

/*
	Author: June Bella
	Title: Web Developer
*/

namespace App\Config\Controller;

use DB;

class AbstractController {
	private $default_template_path = "./resources/default/";
	private $resource_path = "./resources/";

	public function appError($code) {
		if ($code == 404) {
			$this->renderDefaultView('error404');
		} elseif ($code == 500) {
			$this->renderDefaultView('error500');
		}
	}

	public function renderDefaultView($file_path) {
		$app = $this;
		include_once $this->default_template_path.$file_path.'.html';
	}

	public function renderView($file_path) {
		$app = $this;
		include_once $this->resource_path.$file_path.'.html';
	}

	public function redirectToRoute($route) {
		header("Location: $route");
	}

	public function checkLogin($type, $route) {
		$login = $this->getLogin();

		if ($login['type'] != $type) {
			$this->redirectToRoute($route);
		}
	}

	public function setLogin($login) {
		$_SESSION['login'] = $login;
	}

	public function getLogin() {
		if (isset($_SESSION['login'])) {
			return $_SESSION['login'][0];
		} else {
			return null;
		}
	}

	public function clearLogin() {
		unset($_SESSION['login']);
	}

	public function loginData() {
		return (object) $_SESSION['login'][0];
	}

	public function userData() {
		$db = new DB();
		$user_id = $this->loginData()->id;
		$query = "SELECT *
				  FROM m_user
				  WHERE id = $user_id;";
		$result = $db->execute($query);
		return (object) $result[0];
	}

	public function getLoginDetail($column) {
		$login_details = $this->getLogin();
		return $login_details[$column];
	}

	public function checkXHR() {
		if(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			die('Invalid request');
		}
	}
}