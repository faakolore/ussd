<?php


namespace Faakolore\USSD\Http;


use Exception;
use Illuminate\Support\Facades\Validator;
use Faakolore\USSD\Exceptions\UssdException;
use Faakolore\USSD\Exceptions\ValidationException;

trait Validates
{
    /**
     * Define validation rules
     *
     * @return string
     */
    abstract protected function rules(): string;

    abstract protected function getRequestValue();

    /**
     * Validate request data against given rules
     *
     * @param Request $request
     * @param string|null $label
     * @return bool
     * @throws UssdException
     * @throws Exception
     */
    protected function validate(Request $request, string $label = 'value'): bool
    {
        if (empty($this->rules())) throw new Exception("The rules method must return a string of validation rules");

        $validator = Validator::make([$label => $this->getRequestValue()], [$label => $this->rules()]);

        if ($validator->fails()) throw new ValidationException($request, $validator->errors()->first());

        return true;
    }
}
