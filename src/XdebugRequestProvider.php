<?php

namespace DJFM\Xdebug;

use DJFM\Xdebug\XdebugRequest;

class XdebugRequestProvider
{
    private $commands = [];
    
    public function __construct()
    {
        $this->makeListOfCommands();
    }
    
    private function add($action)
    {
        $request = new XdebugRequest;
        $this->commands[$action] = $request;
        return $request->setAction($action);
    }
    
    public function makeListOfCommands()
    {
        $this
            ->add('run')
            ->setDescription(
                'Continue execution until '
                .'there is a reason to stop.'
            );
            
        $this
            ->add('status')
            ->setDescription(
                'What are we doing now?'
            );
    }

    public function getCommands()
    {
        return $this->commands;
    }
    
    public function getCommand($cmd)
    {
        return $this->commands[$cmd];
    }
    
    public function commandExists(string $action)
    {
        return array_key_exists(
            $action,
            $this->commands
        );
    }
}
