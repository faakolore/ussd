<?php


namespace TNM\USSD\Http\Nalo;


use Illuminate\Support\Str;
use TNM\USSD\Http\Request;
use TNM\USSD\Http\UssdRequestInterface;
use TNM\USSD\Models\Session;

class NaloRequest implements UssdRequestInterface
{

    private $request;
    private $type;

    public function __construct()
    {
        $this->request = json_decode(json_encode(simplexml_load_string(request()->getContent())), true);
    }

    public function getMsisdn(): string
    {
        return $this->request['MSISDN'];
    }

    public function getSession(): string
    {
        if (isset($this->request->session)){
            return $this->request->session;
        }
        return Str::random();
    }

    public function getType(): int
    {
        return Session::findBySessionId($this->getSession())->exists() ? Request::RESPONSE : Request::INITIAL;
//        if ($this->request['MSGTYPE']==false){
//            return
//        }
//        return ;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getMessage(): string
    {
        return $this->request['USERDATA'];
    }
}