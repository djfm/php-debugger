<?php

namespace DJFM\Xdebug;

use Monolog\Logger;

use DJFM\Xdebug\XdebugRequest;
use DJFM\Xdebug\XdebugResponseParser;

class DialogConsole
{
    private $logger;

    public function __construct(
        Logger $logger,
        $socket
    ) {
        $this->logger = $logger;
        $this->socket = $socket;
    }
    
    public function chat($ssResults)
    {
        if ($ssResults === 0) {
            $this->logger->info(
                '[c=yellow]Please enter a command (help will help):'
            );
            $command = \readline();
            $this->handleCommand($command);
        }
    }
    
    public function handleCommand($command)
    {
        if ($command = "run") {
            $request = new XdebugRequest();
            $request->setAction('run');
            
            $executor = new XdebugCaller(
                $this->socket,
                $this->logger
            );
            
            $executor->request($request);
        }
    }
}
