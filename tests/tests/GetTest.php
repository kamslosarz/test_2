<?php

class GetTest extends \PHPUnit\Framework\TestCase
{
    private function mockDatabase()
    {
        $database = \app\Database\Database::getInstance();
        $pdo = new PDO('sqlite:memory');
        $pdo->exec('DROP TABLE IF EXISTS `device_orders`');
        $pdo->exec('CREATE TABLE `device_orders` (`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,`name`	varchar(255),`weekday`	varchar(255),`hours`	varchar(255));');

        $pdo->exec("INSERT INTO `device_orders` (`name`, `weekday`, `hours`) VALUES 
        ('Excavator 011', 'Tue', '9:00-11:00'),
        ('Tipper lorry 002', 'Tue', '12:00-13:00'), 
        ('Excavator 011', 'Wed', '06:00-14:00'), 
        ('Excavator 012', 'Thu', '06:00-10:00'),
        ('Excavator 005', 'Thu', '09:45-12:00');
        ");

        $database->setPdo($pdo);
        \app\Database\Database::$instance = $database;
    }

    public function testShouldGetDeviceOrdersList()
    {
        $this->mockDatabase();

        $date = date("Y-m-d");
        $_SERVER['REQUEST_URI'] = '/get';
        $_POST = [
            'date' => $date,
            'n' => 7
        ];

        $app = new \app\Application();
        $response = $app();

        $this->assertEquals(200, $response->getCode());
        $this->assertEquals(7, sizeof($response->getContent()));
        $this->assertEquals([
            '06:00-10:00',
            '09:45-12:00'
        ], $response->getContent()[4]['hours']);
    }
}