<?php


namespace TNM\USSD\Factories;


use TNM\USSD\Http\Flares\FlaresResponse;
use TNM\USSD\Http\Hubtel\HubtelResponse;
use TNM\USSD\Http\Nalo\NaloResponse;
use TNM\USSD\Http\TruRoute\TruRouteResponse;
use TNM\USSD\Http\UssdResponseInterface;
use function request;

class ResponseFactory
{
    public function make(): UssdResponseInterface
    {
        switch (config('ussd.adapter')) {
            case 'flares':
                return resolve(FlaresResponse::class);
            case 'truRoute':
                return resolve(TruRouteResponse::class);
            case 'nalo':
                return resolve(NaloResponse::class);
//            case 'hubtel':
//                return resolve(HubtelResponse::class);
            default:
                return resolve(HubtelResponse::class);
        }
    }
}
