<?php

namespace DJFM\Xdebug;

use Monolog\Logger;

use DJFM\Xdebug\XdebugRequest;
use DJFM\Xdebug\XdebugResponseParser;
use DJFM\Xdebug\XdebugRequestProvider;
use DJFM\Xdebug\XdebugResponse;
use DJFM\Xdebug\XdebugReader;

class DialogConsole
{
    private $logger;

    public function __construct(
        Logger $logger,
        $socket
    ) {
        $this->logger = $logger;
        $this->socket = $socket;
        $this->requestsProvider = new XdebugRequestProvider;
        $this->caller = new XdebugCaller(
            $this->socket,
            $this->logger
        );
    }
    
    public function chat($ssResults)
    {
        if ($ssResults === 0) {
            $this->logger->info(
                '[c=yellow]Please enter a command (help will help):[/c]'
            );
            $userCommand = \readline('#> ');
            
            if (!$this->requestsProvider->commandExists($userCommand)) {
                $this->logger->warn(
                    "[c=red]Unknown command '$userCommand'.[/c]"
                );
                $this->logger->warn(
                    "[c=red]Type 'help' to get the list of "
                    ."available commands.[/c]"
                );
                echo "\n";
                return;
            }
            $this->handleCommand($userCommand);
        }
        
        $parser = new XdebugResponseParser();
        $reader = new XdebugReader($this->socket);
        $resp = $parser->parse($reader->getXdebugRawResponse());
        echo "Xdebug replied:\n\n";
        echo $resp->getPrettyPrintedXML();
        echo "\n\n";
    }
    
    public function handleCommand($command)
    {
        if ($command === 'help') {
            foreach ($this->requestsProvider->getCommands() as $comm) {
                $this->logger->info(
                    "[c=blue]{$comm->getAction()}: {$comm->getDescription()}"
                );
            }
            echo "\n";
            return;
        }
        
        return $this->caller->request(
            $this->requestsProvider->getCommand($command)
        );
    }
}
