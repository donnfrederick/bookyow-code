<?php

namespace App\Vendor;

use DB;

class AppRouter {
	private $route_name;
	private $file_location;

	public function addRouter() {
		$db = new DB();

		$route = '/'.$this->route_name;
		$route_path = $this->file_location;

		if (count($db->execute("SELECT id
								FROM tbl_routes
								WHERE route = '$route'
								AND delete_flg = '0';")) < 1) {
			$insert = "INSERT INTO tbl_routes (route, route_path)
					  VALUES ('$route', '$route_path');";

			$db->execute($insert);

			return "\033[32mSuccesfully added route named: ".$this->route_name;
		} else {
			return "\033[31mRoute already exist";
		}
	}

	public function setRoute($route_name) {
		$this->route_name = $route_name;
	}

	public function setFileLocation($file_location) {
		$this->file_location = $file_location;
	}
}

use App\Vendor\AppRouter;
$app_router = new AppRouter();

require realpath('./').'/vendor/autoload/_routes.php';

if ($console_command == 'add' AND $console_class = 'route') {
	$app_router->setRoute($console_value);
	$app_router->setFileLocation($console_vars);

	if (array_key_exists($console_value, $routes)) {
		echo "\033[31mRoute already exist";
	} else {
		echo $app_router->addRouter();
	}
}

if ($console_command == 'route' AND $console_class = 'list') {
	echo "\033[32mRoute List\n";

	$mask = "%-20s %-35s %-35s \n";
	printf($mask, "\033[39m#", "\033[31mRoute", "\033[33mFile Location");
	$i = 1;
	foreach ($routes as $route => $location) {
		printf($mask, "\033[39m$i", "\033[31m$route", "\033[33m$location");
		$i = $i + 1;
	}
}