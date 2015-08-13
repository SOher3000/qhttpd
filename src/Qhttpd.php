<?php
namespace Qhttpd;


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
        $this->sock = socket_create();
        socket_bind($this->sock, $address, $port);
        socket_listen($this->sock, $bakclog);
    }
    
    public function newTask() {
        $rs = socket_accept($this->sock);
        return new Task($rs);
    }
    
}