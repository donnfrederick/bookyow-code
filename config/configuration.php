<?php

/*
	Author: June Bella
	Title: Web Developer
*/

foreach (glob(__DIR__."/app/entities/*.php") as $filename) {
    require $filename;
}

$modelDirectory = $app_path.'/models/';
$controllerDirectory = $app_path.'/controllers/';
$resourceDirectory = realpath('./resources/');
$htmlDirectory = realpath('./html/');

foreach (glob($conf_path."/controller/*.php") as $controller) {
	require $controller;
}