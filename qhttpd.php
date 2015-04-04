<?php
require __DIR__ . '/vendor/autoload.php';

use Qhttpd\Console;
use Qhttpd\Configuration;
use Qhttpd\Qhttpd;
use Comos\Qpm\Process\Process;


$options = Console::parseArguments();

$defaultConfFile = realpath('qhttpd.conf.php');
$confFile = trim($options->options['configuration']);
$confFile = $confFile ? $confFile : $defaultConfFile;

if (is_file($confFile) && ! is_dir($confFile)) {
    $conf = Configuration::loadFile($confFile);
} else {
    $conf = Configuration::loadFile(__DIR__ . '/qhttpd.conf.php');
}

$qhttpd = new Qhttpd($conf);

if ($options->options['daemon']) {
    Process::fork(function () use($qhttpd)
    {
        Process::toBackground();
        $qhttpd->start();
    });
} else {
    $qhttpd->start();
}