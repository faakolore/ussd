<?php


namespace Faakolore\USSD\Http;


use Faakolore\USSD\Screen;

interface UssdResponseInterface
{
    public function respond(Screen $screen);
}
