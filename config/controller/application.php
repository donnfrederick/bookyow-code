<?php

/*
	Author: June Bella
	Title: Web Developer
*/

$app = new App\Config\Controller\AbstractController();
$req = new App\Config\Controller\RequestController();

$url = $_SERVER['REQUEST_URI'];
$frag = null;
$slashes = explode('/', $url);
array_shift($slashes);

$posible_route = implode('/', array_slice($slashes, 0, -1));

$url_arr = explode('?', $_SERVER['REQUEST_URI']);
$url = $url_arr[0];

if (array_key_exists($url, $routes)) {
	$file = $routes[$url];

	if (file_exists($php_file = $controllerDirectory.$file.'.php')) {
		require $php_file;
	}

	if (file_exists($html_file = $resourceDirectory.'/'.$file.'.html')) {
		$parent_directory = explode('/', $file);

		if (file_exists($header = $resourceDirectory.'/'.$parent_directory[0].'/header.html')) {
			require $header;
		}

		require $html_file;

		if (file_exists($footer = $resourceDirectory.'/'.$parent_directory[0].'/footer.html')) {
			require $footer;
		}
	}
} else {
	if (array_key_exists('/'.$posible_route, $routes)) {
		$file = $routes['/'.$posible_route];

		if (file_exists($php_file = $controllerDirectory.$file.'.php')) {
			require $php_file;
		}

		if (file_exists($html_file = $resourceDirectory.'/'.$file.'.html')) {
			$parent_directory = explode('/', $file);

			if (file_exists($header = $resourceDirectory.'/'.$parent_directory[0].'/header.html')) {
				require $header;
			}

			require $html_file;

			if (file_exists($footer = $resourceDirectory.'/'.$parent_directory[0].'/footer.html')) {
				require $footer;
			}
		}
	} else {
		if (empty($url)) {
			header("Location: /");
		} else {
			$app->appError('404');
		}
	}
}