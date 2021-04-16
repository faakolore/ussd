<?php


namespace TNM\USSD\Http\Hubtel;

use TNM\USSD\Http\UssdResponseInterface;
use TNM\USSD\Screen;

class HubtelResponse implements UssdResponseInterface
{

    /**
     * RESPONSE TYPES:
     */
    /**
     * indicates that the application is ending the USSD session.
     */
    const RELEASE = 'Release';

    /**
     * indicates a response in an already existing USSD session.
     */
    const RESPONSE = 'Response';
    /**
     * @param Screen $screen
     * @return string
     */
    public function respond(Screen $screen): string
    {
        return sprintf(
            "<ussd><type>%s</type><msg>%s</msg><premium><cost>0</cost><ref>NULL</ref></premium></ussd>",
            $screen->type(), $screen->getResponseMessage()
        );
    }
}
