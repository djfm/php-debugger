<?php

namespace DJFM\Xdebug;

use Exception;
use Monolog\Logger;

class XdebugCaller
{
    public function __construct(
        $socket,
        Logger $logger
    ) {
        $this->socket = $socket;
        $this->logger = $logger;
    }
    
    public function counter()
    {
        static $counterAt = 0;
        return $counterAt += 1;
    }
    
    public function request(XdebugRequest $request)
    {
        $transactionId = $this->counter();

        $command = [$request->getAction(), '-i', $transactionId];

        if ($request->getArguments() && count($request->getArguments() > 0)) {
            $argStrings = [];
            foreach ($request->getArguments() as $key => $value) {
                $argStrings[] = "-$key $value";
            }
            $argsPartStr = implode(' ', $argStrings);
            $command[] = $argsPartStr;
        }

        if ($request->getExpression()) {
            $command[] = '--';
            $command[] = \base64_encode($request->getExpression());
        }

        $commandStr = implode(' ', $command);

        $this->logger->info("Sending to Xdebug:\n");
        $this->logger->info('[c=yellow]' . $commandStr . '[/c]');

        $bytesWritten = fwrite($this->socket, $commandStr . "\0");
        if ($bytesWritten === false
        || $bytesWritten !== strlen(
            $commandStr
        ) + 1) {
            throw new Exception(
                'Could not write to socket.'
            );
        }
    }
}
