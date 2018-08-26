<?php

class InsertTest extends \PHPUnit\Framework\TestCase
{
    private function mockDatabase()
    {
        $database = \app\Database\Database::getInstance();
        $pdo = new PDO('sqlite:memory');
        $pdo->exec('DROP TABLE IF EXISTS `device_orders`');
        $pdo->exec('CREATE TABLE `device_orders` (`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,`name`	varchar(255),`weekday`	varchar(255),`hours`	varchar(255));');
        $database->setPdo($pdo);
    }

    public function testShouldInsertDeviceOrder()
    {
        $this->mockDatabase();

        $_SERVER['REQUEST_URI'] = '/insert';
        $_POST = [
            'name' => 'Excavator 012',
            'weekday' => 'Sun',
            'hours' => '9:00-11:00'
        ];

        $app = new \app\Application();
        $response = $app();

        $this->assertEquals(200, $response->getCode());
        $this->assertEquals([], $response->getContent());
    }

    public function testShouldReturnDeviceIsAlreadyAdded()
    {
        $this->mockDatabase();

        $_SERVER['REQUEST_URI'] = '/insert';
        $_POST = [
            'name' => 'Excavator 012',
            'weekday' => 'Sun',
            'hours' => '9:00-11:00'
        ];

        $app = new \app\Application();
        $app();
        $response = $app();

        $this->assertEquals(404, $response->getCode());
        $this->assertEquals(['error' => 'device work hours for this weekday is already defined'], $response->getContent());
    }

}