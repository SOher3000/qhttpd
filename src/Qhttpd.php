<?php

namespace Qhttpd;

class Qhttpd
{
    protected $conf;
    protected $sock;

    public function __construct($conf)
    {
        $this->conf = $conf;
    }

    public function start()
    {
        $this->initSocket();
        $this->startSupervisor();
    }

    protected function initSocket()
    {
        $address = $this->conf->get('address'); // Предположим, что 'address' и 'port' есть в конфигурации
        $port = $this->conf->getInt('port');
        $backlog = $this->conf->getInt('backlog');

        $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($this->sock === false) {
            throw new \Exception("Socket creation failed: " . socket_strerror(socket_last_error()));
        }

        if (!socket_bind($this->sock, $address, $port)) {
            throw new \Exception("Socket binding failed: " . socket_strerror(socket_last_error($this->sock)));
        }

        if (!socket_listen($this->sock, $backlog)) {
            throw new \Exception("Socket listen failed: " . socket_strerror(socket_last_error($this->sock)));
        }
    }

    protected function startSupervisor()
    {
        Supervisor::taskFactoryMode([
            'factory' => [$this, 'newTask'],
            'quantity' => $this->conf->getInt('maxProcesses'),
            'timeout' => $this->conf->getFloat('timeout')
        ])->start();
    }

    public function newTask()
    {
        $rs = socket_accept($this->sock);

        if ($rs === false) {
            throw new \Exception("Socket accept failed: " . socket_strerror(socket_last_error($this->sock)));
        }

        return new Task($rs);
    }
}

