<?php

require_once __DIR__.'/../vendor/autoload.php';

$settings = require_once __DIR__.'/../src/settings/config.php';

$app = new Slim\App($settings);
require_once __DIR__.'/../src/settings/dependencies.php';
require_once __DIR__.'/../src/routers/web.php';

$app->run();