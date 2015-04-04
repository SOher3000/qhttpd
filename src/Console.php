<?php
namespace Qhttpd;

use PEAR2\Console\CommandLine;
use PEAR2\Console\CommandLine\Option;

class Console
{

    /**
     *
     * @return \PEAR2\Console\PEAR2\Console\CommandLine\Result
     */
    public static function parseArguments()
    {
        $cl = new CommandLine();
        $cl->description = 'QHTTPD, a QPM based http server.';
        $cl->version = '0.0.1';
                
        $cl->addOption('configuration', [
            'short_name' => '-c',
            'long_name' => '--conf-file',
            'help_name' => 'CONFIG_FILE',
            'action' => 'StoreString',
            'required' => true,
            'description' => 'the path to configuration file.'
        ]);
        $cl->addOption('daemon', [
            'short_name' => '-d',
            'long_name' => '--daemon',
            'action' => 'StoreFalse',
            'description' => 'run as daemon.'
        ]);
        try {
            $result = $cl->parse();
        } catch (\Exception $ex) {
            $parser->displayError($ex->getMessage());
            exit();
        }
        return $result;
    }
}