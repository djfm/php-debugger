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
        $this->commands[] = $request;
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
}
