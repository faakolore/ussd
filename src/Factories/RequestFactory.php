<?php


namespace TNM\USSD\Factories;


use TNM\USSD\Http\Flares\FlaresRequest;
use TNM\USSD\Http\Hubtel\HubtelRequest;
use TNM\USSD\Http\Nalo\NaloRequest;
use TNM\USSD\Http\TruRoute\TruRouteRequest;
use TNM\USSD\Http\UssdRequestInterface;

class RequestFactory
{
    public function make(): UssdRequestInterface
    {
        switch (config('ussd.adapter')) {
            case 'flares' :
                return resolve(FlaresRequest::class);
            case 'truRoute':
                return resolve(TruRouteRequest::class);
            case 'nalo':
                return resolve(NaloRequest::class);
            default:
                return resolve(HubtelRequest::class);

        }
    }
}
