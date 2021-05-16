<?php


namespace App\USSD\Factory;


use Faakolore\USSD\Http\Flares\FlaresRequest;
use Faakolore\USSD\Http\Hubtel\HubtelRequest;
use Faakolore\USSD\Http\Nalo\NaloRequest;
use Faakolore\USSD\Http\TruRoute\TruRouteRequest;
use Faakolore\USSD\Http\UssdRequestInterface;

class RequestFactory
{
    public function make(): UssdRequestInterface
    {
        switch (request()->route('adapter')) {
            case 'flares' :
                return resolve(FlaresRequest::class);
            case 'truRoute':
                return resolve(TruRouteRequest::class);
            case 'nalo':
                return resolve(NaloRequest::class);
//           case 'hubtel':
//                return resolve(HubtelRequest::class);
            default:
                return resolve(HubtelRequest::class);

        }
    }
}
