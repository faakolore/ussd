<?php


namespace Faakolore\USSD\Exceptions;


use Faakolore\USSD\Http\Request;
use Faakolore\USSD\Screens\Error;

class UssdException extends \Exception
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request, string $message)
    {
        parent::__construct($message);
        $this->request = $request;
    }

    public function render(): string
    {
        return (new Error($this->request, $this->getMessage()))->render();
    }
}
