<?php

$user_id = $app->userData()->id;

$transactions = findByDesc('t_transactions', ['user_id' => $user_id]);

?>