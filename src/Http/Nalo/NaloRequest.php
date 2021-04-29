<?php


namespace TNM\USSD\Http\Nalo;


use TNM\USSD\Http\UssdRequestInterface;

class NaloRequest implements UssdRequestInterface
{

    protected $request;
    protected $type;

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
        return $this->request['USERID'];
    }

    public function getType(): int
    {
        return $this->request['MSGTYPE'];
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getMessage(): string
    {
        return  $this->request['MSG'] ?: $this->request['USERDATA'];
    }
}