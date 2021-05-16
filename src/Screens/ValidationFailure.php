<?php


namespace Faakolore\USSD\Screens;


use Faakolore\USSD\Screen;

class ValidationFailure extends Error
{

    /**
    * Previous screen
    * return Screen $screen
    */
    public function previous(): Screen
    {
        return new $this->request->trail->{'state'}($this->request);
    }

    /**
     * Execute the selected option/action
     *
     * @return mixed
     */
    protected function execute()
    {
        // TODO: Implement execute() method.
    }

    protected function goesBack(): bool
    {
        return true;
    }

    public function acceptsResponse(): bool
    {
        return true;
    }
}
