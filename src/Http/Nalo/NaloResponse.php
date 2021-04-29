<?php


namespace TNM\USSD\Http\Nalo;


use TNM\USSD\Http\UssdResponseInterface;
use TNM\USSD\Screen;

class NaloResponse implements UssdResponseInterface
{

    public function respond(Screen $screen)
    {
        $response = [
            "USERID"=>config('ussd.nalo_user_id'),
            "MSISDN"=>$screen->request->msisdn,
            "USERDATA"=>$screen->request->message,
            "MSG"=>$screen->getResponseMessage(),
            "MSGTYPE"=>$screen->type()
        ];
        return json_encode($response);
    }
}