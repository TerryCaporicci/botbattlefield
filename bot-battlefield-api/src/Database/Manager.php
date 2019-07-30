<?php

namespace Api\Database;

final class Manager
{

    private static
        /**
         * @var  \PDO
         */
        $dbh;

    /**
     * Manager constructor.
     */
    private function __construct()
    {
        $config = json_decode(file_get_contents(__DIR__ . "/../../config/config.json"))->database;
        Manager::$dbh = new \PDO(
            $config->driver
            . ":host=" . $config->host
            . ";dbname=" . $config->name
            . ";charset=" . $config->charset,
            $config->user,
            $config->password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    /**
     * @return \PDO
     */
    public static function getConnection(): \PDO
    {
        if (!Manager::$dbh) {
            new Manager();
        }
        return Manager::$dbh;
    }

}
