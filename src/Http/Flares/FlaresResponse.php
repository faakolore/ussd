<?php


namespace Faakolore\USSD\Http\Flares;


use Faakolore\USSD\Http\UssdResponseInterface;
use Faakolore\USSD\Screen;

class FlaresResponse implements UssdResponseInterface
{
    public function respond(Screen $screen): string
    {
        $content = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $content .= sprintf("<response><msisdn>%s</msisdn>", $screen->request->msisdn);
        $content .= sprintf("<applicationResponse>%s</applicationResponse></response>", $screen->getResponseMessage());
        return $content;
    }
}
