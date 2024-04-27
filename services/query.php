<?php
require "./config/database.php";

function queryAll(string $tableName)
{
    global $dbh;

    $sth = $dbh->prepare("SELECT * FROM $tableName");
    $sth->execute([]);
    return $sth->fetchAll();
}

function query(string $tableName, string $columnName, string $id)
{
    global $dbh;

    $sth = $dbh->prepare("SELECT * FROM $tableName where $columnName = :id");

    $sth->execute(["id" => $id]);
    return $sth->fetchAll()[0];
}
