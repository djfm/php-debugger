<?php
require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 'on');
error_reporting(E_ALL);

use Noodlehaus\Config;
use Noodlehaus\Parser\Json;
use DJFM\Xdebug\Debugger;

$conf = new Config([
    __DIR__ . '/config.dist.json',
    '?' . __DIR__ . './config.json'
], new Json);


$client = new Debugger($conf);

$client->start();
