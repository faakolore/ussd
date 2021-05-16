<?php


namespace Faakolore\USSD\Factories;


use Faakolore\USSD\Http\Request;
use Faakolore\USSD\Screen;

abstract class ScreenFactory
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $value;

    public function __construct(Screen $screen)
    {
        $this->request = $screen->request;
        $this->value = $screen->getRequestValue();
    }

    abstract public function make();
}
