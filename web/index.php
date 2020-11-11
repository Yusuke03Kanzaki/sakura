<?php

// echo 11;
require 'sakura/bootstrap.php';
require 'sakura/MiniBlogApplication.php';

$app = new MiniBlogApplication(true);  //trueがデバックモード

$app->run();
