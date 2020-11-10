<?php

require 'core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registerDir(dirname(__FILE__).'/core');  //'/Applications/MAMP/htdocs/task/core' coreディレクトリをオートロードの対象に
$loader->registerDir(dirname(__FILE__).'/models');  //'/Applications/MAMP/htdocs/task/models' modelsディレクトリをオートロードの対象に
$loader->register();
