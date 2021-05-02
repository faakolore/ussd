<?php


namespace TNM\USSD\Http\Hubtel;

use TNM\USSD\Http\UssdRequestInterface;


class HubtelRequest implements UssdRequestInterface
{
    /**
     * indicates the first message in a USSD Session
     */
    const INITIATION = 'Initiation';

    /**
     * indicates a follow up in an already existing USSD session.
     */
    const RESPONSE = 'Response';

    /**
     * indicates that the subscriber is ending the USSD session.
     */
    const RELEASE = 'Release';

    /**
     * indicates that the USSD session has timed out.
     */
    const TIMEOUT = 'Timeout';

    /**
     * indicates that the user data should not be passed onto Hubtel (Safaricom Only).
     */
    const HIJACKSESSION = 'HijackSession';

    /**
     * @var array|mixed
     */
    private $request;


    /**
     * HubtelRequest constructor.
     */
    public function __construct()
    {
        $this->request = json_decode(request()->getContent(),true);
    }


    /**
     * @return string
     */
    public function getMsisdn(): string
    {
        return $this->request['Mobile'];
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->request['SessionId'];
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->setType($this->request['Type']);
    }

    /**
     * @param $type
     * @return int
     */
    public function setType($type): int
    {
        switch ($type){
            case self::INITIATION:
                return 1;
            case self::RESPONSE:
                return 2;
            case self::RELEASE:
                return 3;
            case self::TIMEOUT:
                return 4;
            default:
                return 0;
        }
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->request['Message']?:$this->getSequence();
    }


    /**
     * @return mixed
     */
    public function getClientState()
    {
        return $this->request['ClientState'];
    }

    /**
     * @return mixed
     */
    public function getServiceCode()
    {
        return $this->request['ServiceCode'];
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->request['Operator'];
    }

    public function getSequence()
    {
        return $this->request['sequence'];
    }
}
