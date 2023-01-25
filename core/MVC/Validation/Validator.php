<?php
declare(strict_types=1);

namespace core\MVC\Validation;

use core\MVC\Validation\RulesTrait;

class Validator
{

    use RulesTrait;

    private ?array $parsedData;

    private array $rulesArray;

    private array $validatorErrors = [];

    const ERROR_MESSAGES = [
        'required' => "To pole jest wymagane",
        'min' => "To pole musi posiadać przynajmniej %s długości",
        'max' => "To pole musi posiadać poniżej %s długości",
        'integer' => "To pole musi być liczbą całkowitą",
        'date' => "To pole musi być datą w formacie YYYY-MM-DD"
    ];

    public function __construct(array|null $request, array $rules)
    {
        $this->parsedData = $request;
        $this->rulesArray = $rules;
    }

    public function validate() : void
    {
        foreach($this->rulesArray as $inputName => $itemValue)
        {
            if (empty(trim($itemValue))) continue 1;

            $rulesArray = explode('|', $itemValue);

            if (!in_array('required', $rulesArray) && !array_key_exists($inputName, $this->parsedData)) continue 1;

            array_walk($rulesArray, function(&$rule) use($inputName) {
                switch (str_contains($rule, ':')) {
                    case true:
                        list($ruleName, $ruleValue) = explode(':', $rule);
                        $result = $this->$ruleName($inputName, (int)$ruleValue);
                        break;
                    case false:
                        $result = $this->$rule($inputName);
                        break;
                }

                if ($result !== true) $this->validatorErrors[$inputName][] = $result;

            });
        }
    }

    public function hasErrors() : bool
    {
        return !empty($this->validatorErrors);
    }

    public function getErrors() : array|bool
    {
        return $this->validatorErrors;
    }

    public function getFirstErrors() : array
    {
        foreach($this->validatorErrors as $key => $value)
        {
            $result[$key] = $value[0];
        }
        return $result;
    }

    public function validated() : array
    {
        $result = array();

        $validated = array_filter($this->parsedData, fn($parsedKey) => !array_key_exists($parsedKey, $this->validatorErrors), ARRAY_FILTER_USE_KEY);

        foreach($validated as $key => $value)
        {
            $key = preg_replace("/[A-Z]/", '_$0', lcfirst($key));
            $result[strtolower($key)] = $value;
        }

        return $result;
    }
}