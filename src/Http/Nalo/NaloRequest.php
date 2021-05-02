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
        if (session()->exists('NALOSESSION') && $this->request['MSGTYPE']==false){
            return session('NALOSESSION');
        }elseif (session()->exists('NALOSESSION')){
            return session('NALOSESSION');
        }
        else{
            session(['NALOSESSION' => Str::slug(now(),'')]);
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