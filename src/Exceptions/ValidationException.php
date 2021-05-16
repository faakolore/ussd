<?php

namespace Faakolore\USSD\Exceptions;

use Faakolore\USSD\Http\Request;
use Faakolore\USSD\Screens\ValidationFailure;

class ValidationException extends UssdException
{
    /**
     * @var Request
     */
    protected $request;

    public function render():string
    {
        return (new ValidationFailure($this->request, $this->getMessage()))->render();
    }
}
