<?php

$user_id = $app->loginData()->id;

$addresses = findBy('t_addresses', ['user_id' => $user_id]);

?>