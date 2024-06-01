<?php

$routes = [];

foreach ($dtb_routes = $db->findAll('tbl_routes') as $route) {
	$route_name = $route['route'];
	$route_path = $route['route_path'];
	$routes[$route_name] = $route_path;
}