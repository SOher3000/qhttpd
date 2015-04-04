<?php
require __DIR__ . '/vendor/autoload.php';

use Qhttpd;
use Comos\Qpm\Process\Process;

$console = Console::init();

$defaultConfFile = realpath('qhttpd.conf.php');
$confFile = trim($console->getOption('conf-file'));
$confFile = $conf ? $conf : $defaultConfFile;

if (is_file($confFile) && ! is_dir($confFile)) {
    $conf = Config::loadFile($confFile);
} else {
    $conf = Config::loadFile(__DIR__ . '/qhttpd.conf.php');
}

$qhttpd = new Qhttpd($conf);

if ($console->getOption('daemon')) {
    Process::fork(function () use($qhttpd)
    {
        Process::toBackground();
        $qhttpd->start();
    });
} else {
    $qhttpd->start();
}