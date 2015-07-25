<?php

error_reporting(0);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$site = new Iamstuartwilson\Site(CONFIG_BASE_URL, defined('CONFIG_DEV'));

$site->serve();
