<?php

namespace app\Database;


use app\Config;
use PDO;

class Database
{
    static $instance;
    /** @var PDO $pdo */
    private $pdo;
    private $test = 0;

    public function __construct()
    {
        if (self::$instance instanceof Database) {
            throw new \Exception('Database instance already exists');
        }
    }

    public static function getInstance()
    {
        if (self::$instance instanceof Database) {

            return self::$instance;
        } else {

            self::$instance = new Database();
            self::$instance->connect();

            return self::$instance;
        }
    }

    private function getConfig()
    {
        return Config::load()['database'];
    }

    public function connect()
    {
        $config = $this->getConfig();
        $connection = $config[$config['connection']];
        $this->pdo = new PDO($connection[0], $connection[1], $connection[2], $connection[3]);
    }

    public function setPdo($pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function insert($table, $data)
    {
        $names = $values = '';

        foreach ($data as $k => $v) {
            $names .= sprintf('`%s`, ', $k);
            $values .= sprintf(':%s, ', $k);
        }

        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, rtrim($names, ', '), rtrim($values, ', '));
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $k => $v) {
            $stmt->bindParam(sprintf(':%s', $k), $data[$k]);
        }

        return $stmt->execute();
    }

    public function select(array $query = [], array $bind = [])
    {
        $sql = sprintf('SELECT %s FROM %s WHERE %s', $query['select'], $query['from'], $query['where']);
        $stmt = $this->pdo->prepare($sql);

        if (!empty($bind)) {
            foreach ($bind as $key => $param) {
                $stmt->bindParam($key, $bind[$key]);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function execute($sql)
    {
        return $this->pdo->exec($sql);
    }
}