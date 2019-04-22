<?php

namespace DJFM\Xdebug;

use Exception;

class ResponseReceiver
{
    public function __construct($socket)
    {
        $this->socket = $socket;
    }
    public function getXdebugRawResponse()
    {
        $sock = [$this->socket];
        $void = [];
        $ssResults = \stream_select($sock, $void, $void, 1);
        if ($ssResults === 0) {
            throw new Exception(
                'Xdebug did not reply. Probably wrong command.'
            );
        }
        // TODO: try with stream_get_contents
        $txt = fread($this->socket, 4096);
        return $txt;
    }
}
