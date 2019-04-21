<?php

namespace DJFM\Xdebug;

use SimpleXMLElement;

class XdebugResponse
{
    /**
     * The original response received.
     * @var string
     */
    private $original;
    
    /**
     * The parsed text of the response.
     * @var text
     */
    private $text;
    
    /**
     * The length of the response;
     * @var number
     */
    private $len;

    /**
     * The XML version of the response.
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * Get the value of The original response received.
     *
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }
 
    /**
     * Set the value of The original response received.
     *
     * @param string original
     *
     * @return self
     */
    public function setOriginal($original)
    {
        $this->original = $original;
 
        return $this;
    }
 
    /**
     * Get the value of The parsed text of the response.
     *
     * @return text
     */
    public function getText()
    {
        return $this->text;
    }
 
    /**
     * Set the value of The parsed text of the response.
     *
     * @param string text
     *
     * @return self
     */
    public function setText(string $text)
    {
        $this->text = $text;
 
        return $this;
    }
 
    /**
     * Get the value of The length of the response;
     *
     * @return number
     */
    public function getLen()
    {
        return $this->len;
    }
 
    /**
     * Set the value of The length of the response;
     *
     * @param number len
     *
     * @return self
     */
    public function setLen($len)
    {
        $this->len = $len;
 
        return $this;
    }
 
    /**
     * Get the value of The XML version of the response.
     *
     * @return SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }
 
    /**
     * Set the value of The XML version of the response.
     *
     * @param SimpleXMLElement xml
     *
     * @return self
     */
    public function setXml(SimpleXMLElement $xml)
    {
        $this->xml = $xml;
 
        return $this;
    }
}
