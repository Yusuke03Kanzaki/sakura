<?php

require 'task/bootstrap.php';
require 'task/MiniBlogApplication.php';

// $app = new MiniBlogApplication(true);  //trueがデバックモード
$app = new MiniBlogApplication(true);  //trueがデバックモード

$app->run();
