<?php

namespace app\Model;


use app\Database\Database;
use app\Validator\Validator;

class DeviceOrder
{
    static $database;

    private $data;

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function isValid()
    {
        $results = self::getDatabase()->select([
            'select' => '*',
            'from' => 'device_orders',
            'where' => 'name LIKE :name AND weekday LIKE :weekday'
        ], [
            ':name' => $this->data['name'],
            ':weekday' => $this->data['weekday']
        ]);

        return empty($results);
    }

    public function save()
    {
        return self::getDatabase()->insert('device_orders', $this->data);
    }

    /**
     * @return Database
     */
    private static function getDatabase()
    {

        if (self::$database instanceof Database) {

            return self::$database;
        }

        self::$database = Database::getInstance();

        return self::$database;
    }

    public static function findFromDate($date, $n)
    {
        $weekdayInt = date('N', strtotime($date)) - 1;
        $weekdays[sprintf(':%s', strtolower(Validator::WEEKDAYS[$weekdayInt]))] = Validator::WEEKDAYS[$weekdayInt];

        $i = $weekdayInt;

        while ($n) {
            if ($i === sizeof(Validator::WEEKDAYS) - 1) {
                $i = 0;
            } else {
                $i += 1;
            }

            $weekdays[sprintf(':%s', strtolower(Validator::WEEKDAYS[$i]))] = Validator::WEEKDAYS[$i];
            $n--;
        }

        $results = self::getDatabase()->select([
            'select' => 'weekday, name, hours',
            'from' => 'device_orders',
            'where' => sprintf('weekday IN (%s)', implode(', ', array_keys($weekdays)))
        ], $weekdays);

        return $results;
    }
}