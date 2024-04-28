<?php

class Database
{
    private PDO $dbh;

    private string $user = "root";
    private string $pass = "vannguyenv12";

    public function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=ecommerce_php', $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function queryAll(string $tableName)
    {
        $sth = $this->dbh->prepare("SELECT * FROM $tableName");
        $sth->execute([]);
        return $sth->fetchAll();
    }

    public function query(string $tableName, string $columnName, string $id)
    {
        $sth = $this->dbh->prepare("SELECT * FROM $tableName where $columnName = :id");

        $sth->execute(["id" => $id]);
        return $sth->fetchAll()[0];
    }

    // public function customQuery(string $query, string $columnName, string $columnValue)
    // {
    //     $sth = $this->dbh->prepare($query);

    //     $sth->execute([$columnName => $columnValue]);
    //     return $sth->fetchAll();
    // }

    public function customQuery(string $query, array $params)
    {
        $sth = $this->dbh->prepare($query);
        $sth->execute($params);
        return $sth->fetchAll();
    }

    private function normalize(string $tableName, array $columns): string
    {
        $key = implode(",", $columns);

        $values = "";

        for ($i = 0; $i < sizeof($columns); $i++) {
            $values = $values . '?,';
        }

        $values = trim($values, ',');

        $statement = "INSERT INTO $tableName ($key) VALUES ($values)";

        return $statement;
    }

    public function insert(string $tableName, array $columnKeys, array $columnValues): void
    {
        $insertString = $this->normalize($tableName, $columnKeys);

        $sth = $this->dbh->prepare($insertString);

        $sth->execute($columnValues);
    }

    public function update(string $tableName, array $columnKeys, array $columnValues, string $conditionColumn, string $conditionValue): void
    {
        $setString = '';

        foreach ($columnKeys as $index => $key) {
            $setString .= "$key = ?, ";
        }
        $setString = rtrim($setString, ', ');

        $query = "UPDATE $tableName SET $setString WHERE $conditionColumn = ?";

        $mergedValues = array_merge($columnValues, [$conditionValue]);

        $sth = $this->dbh->prepare($query);
        $sth->execute($mergedValues);
    }

    public function delete(string $tableName, string $conditionColumn, string $conditionValue): void
    {
        $query = "DELETE FROM $tableName WHERE $conditionColumn = ?";

        $sth = $this->dbh->prepare($query);
        $sth->execute([$conditionValue]);
    }

    public function exists(string $tableName, string $columnName, $value): bool
    {
        try {
            $query = "SELECT COUNT(*) FROM $tableName WHERE $columnName = ?";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute([$value]);
            $count = $stmt->fetchColumn();

            return ($count > 0); // Trả về true nếu có ít nhất một hàng có giá trị cần kiểm tra
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
