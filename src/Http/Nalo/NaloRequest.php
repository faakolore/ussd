<?php


namespace Faakolore\USSD\Http\Nalo;


use Illuminate\Support\Str;
use Faakolore\USSD\Http\Request;
use Faakolore\USSD\Http\UssdRequestInterface;
use Faakolore\USSD\Models\Session;

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
        if (session()->has('NALOSESSION') && $this->request['MSGTYPE']==false){
            return session('NALOSESSION');
        }elseif (session()->has('NALOSESSION') && $this->request['MSGTYPE']==true){
            return session('NALOSESSION');
        }
        else{
            session(['NALOSESSION' => Str::slug(now(),'')]);
            return session('NALOSESSION');
        }
    }

    public function getType(): int
    {
            return Session::findBySessionId($this->getSession())->exists() ?
              : $this->setType($this->request['MSGTYPE']);
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