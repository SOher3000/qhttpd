<?php
namespace Qhttpd;

use Comos\Qpm\Supervision\Supervisor;

class Qhttpd
{

    protected $conf;

    public function __construct($conf)
    {
        $this->conf = $conf;
    }

    public function start()
    {
        $this->initSocket();
        Supervisor::taskFactoryMode([
            'factory' => [
                $this,
                'newTask'
            ],
            'quantity' => $conf->getInt('maxProcesses'),
            'timeout' => $conf->getFloat('timeout')
        ])->start();
    }
    
    protected function initSocket() {
        
    }
    public function newTask() {
        
    }
    
}