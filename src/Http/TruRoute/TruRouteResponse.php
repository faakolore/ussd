<?php


namespace Faakolore\USSD\Http\TruRoute;


use Faakolore\USSD\Http\UssdResponseInterface;
use Faakolore\USSD\Screen;

class TruRouteResponse implements UssdResponseInterface
{
    public function respond(Screen $screen): string
    {
        return sprintf(
            "<ussd><type>%s</type><msg>%s</msg><premium><cost>0</cost><ref>NULL</ref></premium></ussd>",
            $screen->type(), $screen->getResponseMessage()
        );
    }
}
