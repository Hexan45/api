<?php
declare(strict_types=1);

namespace core\MVC\Validation;

trait RulesTrait
{
    private function required(string $inputName) : string|bool
    {
        return (isset($this->parsedData[$inputName])) ?: self::ERROR_MESSAGES['required'];
    }

    private function min(string $inputName, int $minValue) : string|bool
    {
        return strlen($this->parsedData[$inputName]) >= $minValue ?: sprintf(self::ERROR_MESSAGES['min'], $minValue);
    }

    private function max(string $inputName, int $maxValue) : string|bool
    {
        return strlen($this->parsedData[$inputName]) <= $maxValue ?: sprintf(self::ERROR_MESSAGES['max'], $maxValue);
    }

    private function integer(string $inputName) : string|bool
    {
        return is_integer(filter_var($this->parsedData[$inputName], FILTER_VALIDATE_INT)) ? true : self::ERROR_MESSAGES['integer'];
    }

    public function date(string $inputName) : string|bool
    {
        return (bool)preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->parsedData[$inputName]) ?: self::ERROR_MESSAGES['date'];
    }
}