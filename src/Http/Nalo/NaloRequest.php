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
        $this->request = json_decode(request()->getContent(),true);
    }

    public function getMsisdn(): string
    {
        return $this->request['MSISDN'];
    }

    public function getSession(): string
    {
        if (isset($this->request['nalo_session']) && $this->request['MSGTYPE']==false){
            return $this->request['nalo_session'];
        }else{
            return $this->request['nalo_session'] = Str::slug(now(),'');
        }
    }

    public function getType(): int
    {
//            return Session::findBySessionId($this->getSession())->exists() ?
//                Request::RESPONSE : Request::INITIAL;
        return $this->setType($this->request['MSGTYPE']);
    }

    public function setType($type): int
    {
        switch ($type){
            case false:
                return Request::INITIAL;
            case true:
                return Request::RESPONSE;
        }
        $this->type = $type;
    }

    public function getMessage(): string
    {
        return $this->request['USERDATA'];
    }
}