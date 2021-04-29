<?php


namespace TNM\USSD\Http\Hubtel;

use TNM\USSD\Http\UssdRequestInterface;


class HubtelRequest implements UssdRequestInterface
{
    /**
     * indicates the first message in a USSD Session
     */
    const INITIAL = 'Initiation';

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
     * @var null |string
     */
    protected $mobile;
    /**
     * @var null |string
     */
    protected $sessionId;
    /**
     * @var null |string
     */
    protected $serviceCode;
    /**
     * @var null |string
     */
    protected $type;
    /**
     * @var null |string
     */
    protected $message;
    /**
     * @var null |string
     */
    protected $operator;
    /**
     * @var null |string
     */
    protected $sequence;
    /**
     * @var null |string
     */
    protected $clientState;

    /**
     * HubtelRequest constructor.
     * @param null[] $options
     */
    public function __construct($options = ["Mobile"=>null,"SessionId"=>null,"ServiceCode"=>null,"Type"=>null,"Message"=>null,"Operator"=>null,"Sequence"=>null,"ClientState"=>null])
    {
        $this->mobile = $options['Mobile'];
        $this->sessionId = $options['SessionId'];
        $this->serviceCode = $options['ServiceCode'];
        $this->type = $options['Type'];
        $this->message = $options['Message'];
        $this->operator = $options['Operator'];
        $this->sequence = $options['Sequence'];
        $this->clientState = $options['ClientState'];
        $this->request = json_decode(request()->getContent(),true);
    }

    public static function createInstance($options): HubtelRequest
    {
        return new self($options);
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
        return $this->request['Type'];
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->request['Message'];
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
        return $this->request['Sequence'];
    }
}
