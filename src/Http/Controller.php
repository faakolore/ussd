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
        if ($request->isJson()){
            throw new UssdException($request, 'Whoops! The system could not process your request. Please try again later');
        }
        else{
            return (new EntryScreenFactory($request))->make();
        }
    }
}
