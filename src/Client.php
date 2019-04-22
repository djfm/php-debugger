<?php

namespace DJFM\Xdebug;

use Noodlehaus\Config;
use Monolog\Logger;
use Monolog\Handler\StdoutHandler;

use DJFM\Xdebug\XdebugResponse;

use Exception;

class Client
{
    private $config;
    private $socket;
    private $logger;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $stdoutHandler = new StdoutHandler();
        $logger = new Logger('XdebugClient');
        $logger->pushHandler($stdoutHandler);
        $this->logger = $logger;

        // colors for logger:
        // black, blue, green, cyan, red,
        // purple, yellow, white
    }
    
    /**
     * @SuppressWarnings(CamelCase)
     */
    public function start()
    {
        $addr = $this->config['server']['address'];
        $port = $this->config['server']['port'];
        $this->logger->info(
            "[c=green]Debugger ready and waiting "
            ."for a connection on $addr:$port [/c]"
        );

        $errno = 0;
        $errstr = '';

        $server = stream_socket_server(
            "$addr:$port",
            $errno,
            $errstr
        );
        
        $this->socket = stream_socket_accept($server);

        $initPacket = fread($this->socket, 4096);
        
        $XdebugResponse = (new XdebugResponseParser)
                                ->parse($initPacket);
        $this->logger->info(
            '[c=green]XDebug said something in XML.[/c]'
        );
        echo "\n";

        $this->logger->info($XdebugResponse->getText());
        echo "\n";

        $nodeName = $XdebugResponse
                        ->getXML()
                        ->getName()
        ;

        if ($nodeName !== 'init') {
            throw new Exception(
                'First message from Xdebug '
                ."should be an 'init' node, we"
                ." got a '$nodeName'."
            );
        }
        
        $this->logger->info(
            'You did not understand this, '
            .'nor did we, at least not a lot. '
            .'Good thing is it is an '
            .'[c=green]init[/c] node!'
        );
        echo "\n";
        
        $this->logger->info(
            '[c=green]We are now connected to Xdebug![/c]'
        );
        echo "\n";

        fclose($server);
        stream_set_blocking(STDIN, 0);
        
        $this->mainLoop();
    }
    
    public function mainLoop()
    {
        $exit = false;
        $console = new DialogConsole(
            $this->logger,
            $this->socket
        );
        do {
            $read = [STDIN];
            $void = [];
            $ssResults = stream_select(
                $read,
                $void,
                $void,
                1
            );
            
            if ($ssResults === false) {
                throw new Excepion(
                    'Stream select failed for some reason.'
                );
            }
            $console->chat($ssResults);
        } while (!$exit);
    }
}
