<?php

namespace app\Validator;


class InsertValidator extends Validator
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->errors = [];
    }

    public function __invoke()
    {
        if (!isset($this->data['name']) || !preg_match('/[a-zA-z\ 0-9]+/', $this->data['name'])) {

            $this->errors[] = 'Invalid machine name';
        }

        if (!isset($this->data['weekday']) || !in_array($this->data['weekday'], parent::WEEKDAYS)) {

            $this->errors[] = 'Invalid weekday';
        }

        if (!isset($this->data['hours']) || !preg_match('/[0-9]{1,2}:[0-9]{1,2}-[0-9]{1,2}:[0-9]{1,2}/', $this->data['hours'])) {

            $this->errors[] = 'Invalid hour interval';
        } else {
            $hours = explode('-', $this->data['hours']);

            foreach ($hours as $timestamp) {
                $timestamps = explode(':', $timestamp);
                if ($timestamps[0] < 0 || $timestamps[0] > 24) {
                    $this->errors[] = 'Invalid hour interval';

                    return false;
                }
                if ($timestamps[1] < 0 || $timestamps[0] > 59) {
                    $this->errors[] = 'Invalid hour interval';

                    return false;
                }
            }
        }

        return empty($this->errors);
    }

}