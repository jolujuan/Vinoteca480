<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->bootEnv(dirname(__DIR__).'/.env.test');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
