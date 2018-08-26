<?php

namespace app\Validator;


class GetValidator extends Validator
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->errors = [];
    }

    function __invoke()
    {
        if (!isset($this->data['date'])) {

            $this->errors[] = 'Invalid date';

            return false;
        }

        if (!preg_match('/[0-9]+\-[0-9]{0,2}\-[0-9]{0,2}/', $this->data['date'])) {

            $this->errors[] = 'Invalid date (Y-m-d';
        }

        if (!(bool)strtotime($this->data['date'])) {

            $this->errors[] = 'Date not exists';
        }

        if (isset($this->data['n'])) {

            if (!is_numeric($this->data['n'])) {

                $this->errors[] = 'Invalid number of days';
            }

            if ($this->data['n'] < 0 || $this->data['n'] > 7) {

                $this->errors[] = 'Invalid number of days (0-7)';
            }
        }

        return empty($this->errors);
    }
}