<?php
namespace Qhttpd\Message;

class MessageParser
{
    protected $curState;
    public function lineIn($line) 
    {
        if (self::isEmptyLine) {
            $nextState = $curState->emptyLine($this);
            return;
        }
    }
}