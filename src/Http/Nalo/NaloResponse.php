<?php


namespace TNM\USSD\Http\Nalo;


use TNM\USSD\Http\Request;
use TNM\USSD\Http\UssdResponseInterface;
use TNM\USSD\Models\Session;
use TNM\USSD\Screen;

class NaloResponse implements UssdResponseInterface
{

    private $type;

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = (bool)Session::findBySessionId($type->request->getSession())->exists();
    }

    public function respond(Screen $screen)
    {
        $this->setType($screen);
        $response = [
            "USERID"=>config('ussd.nalo_user_id'),
            "MSISDN"=>$screen->request->msisdn,
            "USERDATA"=>$screen->request->message,
            "MSG"=>$screen->getResponseMessage(),
            "MSGTYPE"=>$this->type
        ];
        return json_encode($response);
    }
}