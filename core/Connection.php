<?php
class Connection {
    private static $instance = null;
    private $conn = null;

    private function __construct($config, $pass) {
        // Kết nối database
        try {
            // Cấu hình dsn
            $dsn = 'mysql:dbname=' . $config['db'] . ';host=' . $config['host'];

            // Cấu hình $options
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            // Câu lệnh kết nối
            $this->conn = new PDO($dsn, $config['user'], $pass, $options);

        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            die();
        }
    }

    public static function getInstance($config, $pass) {
        if (self::$instance === null) {
            self::$instance = new Connection($config, $pass);
        }

        return self::$instance->conn;
    }
}
