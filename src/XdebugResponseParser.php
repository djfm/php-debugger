<?php

namespace DJFM\Xdebug;

use SimpleXMLElement;

class XdebugResponseParser
{
    public function parse($origStr)
    {
        $response = new XdebugResponse;
        $responseArray = explode("\0", $origStr);
        $response
            ->setOriginal($origStr)
            ->setLen((int)$responseArray[0])
            ->setText($responseArray[1])
            ->setXml(new SimpleXMLElement($response->getText()))
        ;
        list($rlen, $llen) = [
            $response->getLen(),
            strlen(
                $response->getText()
            )
        ];

        if ($llen !== $rlen) {
            throw new Exception(
                "Response received got '$rlen' "
                ."bytes instead of '$llen' expected"
            );
        };
        
        return $response;
    }
}
