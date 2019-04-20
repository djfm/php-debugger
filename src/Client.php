<?php

namespace DJFM\Xdebug;

use Noodlehaus\Config;
use Monolog\Logger;
use Monolog\Handler\StdoutHandler;

use DJFM\XDebug\Response;

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
    
    public function start()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        
        $addr = $this->config['server']['address'];
        $port = $this->config['server']['port'];
        
        $bound = socket_bind(
            $this->socket,
            $addr
        );
        
        if (!$bound) {
            throw new Exception(
                'Could not bind socket.'
            );
        }
        
        $listening = socket_listen($this->socket, 0);
        
        if (!$listening) {
            throw new Exception(
                "Could not listen on $addr:$port."
            );
        }
        
        $this
            ->logger
            ->info(
                "[c=green]Bound to $addr:$port and now waiting.[/c]"
            );
            
        while (($ressource = socket_accept($this->socket))) {
            $incoming = '';

            while ($str !== null) {
                socket_recv($ressource, $str, 1024, MSG_DONTWAIT);
                $incoming .= $str;
            }
            
            $this->handleMessage($incoming, $ressource);
        }
    }
    
    private function counter()
    {
        static $counterAt = 0;
        $counterAt += 1;
        return $counterAt;
    }
    
    private function handleMessage($incoming, $ressource)
    {
        $message = new Response($incoming);
        
        $this->logger->info('XDebug said something in XML');
        
        $rootNode = $message->getXML()->getName();
        
        $message = "The root node is '$rootNode'";
        
        $this->logger->info($message);
        
        readline("Stopped on error. Continue? [yes or yes]");
        
        $transactionId = $this->counter();
        $cmd = "run -i $transactionId -- \0";
        socket_write($ressource, $cmd);
    }
}
