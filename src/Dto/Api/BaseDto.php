<?php

namespace App\Dto\Api;

use Symfony\Component\Validator\ConstraintViolationList;

class BaseDto
{
    private ConstraintViolationList $errors;

    /**
     * @param ConstraintViolationList $errors
     * @return void
     */
    public function setErrors(ConstraintViolationList $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return isset($this->errors) && count($this->errors) > 0;
    }

    /**
     * Converts ConstraintViolationList list of errors to associative array and returns it.
     *
     * @return array
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errors;
    }
}