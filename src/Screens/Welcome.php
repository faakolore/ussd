<?php


namespace Faakolore\USSD\Screens;


use Faakolore\USSD\Screen;

class Welcome extends Screen
{

    /**
     * Add message to the screen
     *
     * @return string
     */
    protected function message(): string
    {
        return config('ussd.welcome');
    }

    /**
     * Add options to the screen
     * @return array
     */
    protected function options(): array
    {
        return config('ussd.options');
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

    public function previous(): Screen
    {
        // TODO: Implement previous() method.
    }
}
