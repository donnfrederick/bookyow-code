<?php

session_start();

$app_path = realpath('./app/');
$conf_path = realpath('./config/');
$html_path = realpath('./html/');

$app_name = "Bookyow";

foreach (glob(__DIR__."/vendor/autoload/*.php") as $filename) {
    require $filename;
}

$conf = $conf_path.'/configuration.php';

if (!file_exists($conf) && !is_readable($conf)) {
	die('App Configuration is missing');
}

require $conf;