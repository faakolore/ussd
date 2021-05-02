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
        if (request()->session()->has('NALOSESSION') && $this->request['MSGTYPE']==false){
            return request()->session()->get('NALOSESSION');
        }elseif (request()->session()->has('NALOSESSION')){
            return request()->session()->get('NALOSESSION');
        }
        else{
            request()->session()->put('NALOSESSION', Str::slug(now(),''));
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