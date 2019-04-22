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
        foreach ($this->requestsProvider->getCommands() as $comm) {
            if ($command !== 'help') {
                if ($comm->getAction() === $command) {
                    return $this->caller->request($comm);
                }
            }
        }
        
        if ($command !== 'help') {
            $this->logger->warn(
                "[c=red]Unknown command '$command'.[/c]"
            );
            $this->logger->warn(
                "[c=red]Type 'help' to get the list of "
                ."available commands.[/c]"
            );
            echo "\n";
        }
        
        if ($command === 'help') {
            foreach ($this->requestsProvider->getCommands() as $comm) {
                $this->logger->info(
                    "[c=blue]{$comm->getAction()}: {$comm->getDescription()}"
                );
            }
            echo "\n";
        }
    }
}
