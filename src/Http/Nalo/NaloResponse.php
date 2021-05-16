<?php


namespace Faakolore\USSD\Http\Nalo;


use Faakolore\USSD\Http\Request;
use Faakolore\USSD\Http\UssdResponseInterface;
use Faakolore\USSD\Models\Session;
use Faakolore\USSD\Screen;

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
            "MSGTYPE"=>$this->type,
            "NALOSESSION"=>$screen->request->getSession(),
        ];
        return json_encode($response);
    }
}