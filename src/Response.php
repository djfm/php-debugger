<?php

namespace DJFM\Xdebug;

/**
 * Parses a response from XDebug
 */
class Response
{
    private $responseLength;
    private $responseText;
    private $responseXML;

    public function __construct($responseText)
    {
        list($len, $txt) = explode("\0", $responseText);
        $this->responseLength = $len;
        $this->responseText = $txt;
        $this->responseXML = new \SimpleXMLElement($txt);
    }
    
    public function fullText()
    {
        return $this->responseText;
    }
    
    public function getXML()
    {
        return $this->responseXML;
    }
}
