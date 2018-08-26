<?php

namespace app\Validator;

abstract class Validator
{
    const WEEKDAYS = ['Mon', 'Tue', 'Wen', 'Thu', 'Fri', 'Sat', 'Sun'];

    protected $errors;

    public function getErrors()
    {
        return $this->errors;
    }

    abstract function __construct($data);

    abstract function __invoke();
}