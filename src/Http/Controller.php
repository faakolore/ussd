<?php


namespace TNM\USSD\Http;

use Illuminate\Routing\Controller as BaseController;
use TNM\USSD\Exceptions\UssdException;
use TNM\USSD\Factories\EntryScreenFactory;

class Controller extends BaseController
{
    /**
     * @param Request $request
     * @return mixed|string
     * @throws UssdException
     */
    public function __invoke(Request $request)
    {
        return (new EntryScreenFactory($request))->make();
    }
}
