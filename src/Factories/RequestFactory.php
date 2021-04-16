<?php


namespace TNM\USSD\Factories;


use TNM\USSD\Http\Flares\FlaresRequest;
use TNM\USSD\Http\TruRoute\TruRouteRequest;
use TNM\USSD\Http\UssdRequestInterface;

class RequestFactory
{
    public function make(): UssdRequestInterface
    {
        switch (request()->route('adapter')) {
            case 'flares' :
                return resolve(FlaresRequest::class);
            case 'hubtel':
                return resolve(HubtelRequest::class);
            default:
                return resolve(TruRouteRequest::class);
        }
    }
}
