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




//$clientState = null;
//if (array_key_exists('ClientState', $arr)) {
//$clientState = $arr['ClientState'];
//}
//
//$mobile = $arr['Mobile'];
//$sessionId = $arr['SessionId'];
//$serviceCode = $arr['ServiceCode'];
//$type = $arr['Type'];
//$message = $arr['Message'];
//$operator = $arr['Operator'];
// $sequence = $arr['Sequence'];

    /**
     * HubtelRequest constructor.
     */
    public function __construct()
    {
        $this->request = json_decode(json_encode(simplexml_load_string(request()->getContent())), true);
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
        return $this->request['ServiceCOde'];
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
