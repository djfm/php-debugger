<?php

namespace DJFM\Xdebug;

class XdebugRequest
{
    /**
     * What this does in human
     * @var [type]
     */
    private $description;
    
    /**
     * What to do
     * @var string
     */
    private $action;
    
    /**
     * The arguments for the action.
     * @var array
     */
    private $arguments = [];
    
    /**
     * An expression in PHP
     * that will be evaluated by the remote script.
     * @var string
     */
    private $expression;

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
 
    /**
     * Set the value of What to do
     *
     * @param string $action
     *
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;
 
        return $this;
    }
 
    /**
     * Get the value of The arguments for the action.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
 
    /**
     * @param array $arguments
     * @return self
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
 
        return $this;
    }
 
    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }
 
    /**
     * @param string $expression
     * @return self
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
 
        return $this;
    }
    
    

    /**
     * Get the value of What this does in human terms
     *
     * @return [type]
     */
    public function getDescription()
    {
        return $this->description;
    }
 
    /**
     * @param string $description
     * @return self
     */
    public function setDescription(...$description)
    {
        $this->description = implode(' ', $description);
 
        return $this;
    }
}
