<?php


namespace TNM\USSD\Http\Hubtel;

use TNM\USSD\Http\UssdResponseInterface;
use TNM\USSD\Screen;

class HubtelResponse implements UssdResponseInterface
{

    protected $message;
    protected $type;
    protected $clientState;
    protected $maskNextRoute;

    public function __construct($message = null, $type = null, $clientState = null, $maskNextRoute=false)
    {
        $this->message = $message;
        $this->type = $type;
        $this->clientState = $clientState;
        $this->maskNextRoute = $maskNextRoute;
    }

    public static function createInstance($message = null, $type = null, $clientState = null, $maskNextRoute=false): HubtelResponse
    {
        return new self($message, $type, $clientState, $maskNextRoute);
    }

    /**
     * @param Screen $screen
     * @return string
     */
    public function respond(Screen $screen): string
    {
        return $this->toJson($screen);
    }

    /**
     * @return mixed|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed|null
     */
    public function getClientState()
    {
        return $this->clientState;
    }

    /**
     * @param $clientState
     */
    public function setClientState($clientState)
    {
        $this->clientState = $clientState;
    }

    /**
     * @return false|mixed
     */
    public function getMaskNextRoute()
    {
        return $this->maskNextRoute;
    }

    /**
     * @param $maskNextRoute
     */
    public function setMaskNextRoute($maskNextRoute)
    {
        $this->maskNextRoute = $maskNextRoute;
    }

    /**
     * @param Screen $screen
     * @return false|string
     */
    public function toJson(Screen $screen)
    {
        return json_encode([
            "Message"=>$screen->getResponseMessage(),
            "Type"=>$this->setType($screen->type()),
            "ClientState"=>$this->clientState,
            "MaskNextRoute"=>$this->maskNextRoute,
//            "SessionId" => $screen->request->session
        ]);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "Message"=>$this->message,
            "Type"=>$this->type,
            "ClientState"=>$this->clientState,
            "MaskNextRoute"=>$this->maskNextRoute
        ];
    }

    /**
     * @param $type
     * @return string
     */
    public function setType($type): string
    {
        switch ($type){
            case 1:
                return HubtelRequest::INITIATION;
            case 2:
                return HubtelRequest::RESPONSE;
            case 3:
                return HubtelRequest::RELEASE;
            case 4:
                return HubtelRequest::TIMEOUT;
            default:
                return '';
        }
    }

}
