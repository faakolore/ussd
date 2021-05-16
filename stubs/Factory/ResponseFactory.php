<?php


namespace App\USSD\Factory;


use Faakolore\USSD\Http\Flares\FlaresResponse;
use Faakolore\USSD\Http\Hubtel\HubtelResponse;
use Faakolore\USSD\Http\Nalo\NaloResponse;
use Faakolore\USSD\Http\TruRoute\TruRouteResponse;
use Faakolore\USSD\Http\UssdResponseInterface;
use function request;

class ResponseFactory
{
    public function make(): UssdResponseInterface
    {
        switch (request()->route('adapter')) {
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
