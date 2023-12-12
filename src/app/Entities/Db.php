<?php

namespace App\Entities;

class Db
{

    private \PDO $dbh;

    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=127.0.0.1;dbname=name', 'user', 'password');
    }

    private function checkType($value): string
    {
        return gettype($value);
    }

    public function query(string $sql, array $params = [], $class = \stdClass::class): array
    {
        $sth = $this->dbh->prepare($sql);

        foreach ($params as $key => &$val) {
            if ($this->checkType($val) === "integer") {
                $sth->bindParam($key, $val, \PDO::PARAM_INT);
            } else {
                $sth->bindParam($key, $val);
            }
        }

        $sth->execute();

        return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
    }

}
