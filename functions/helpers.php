<?php
session_start();

function isLoggedIn(){
    return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
}

function redirect($url){
    header("location: " . $url);
    exit();
}

function sanitizeInput($input){
    return strip_tags(trim($input));
}

function dbSelect($table, $columns = '*', $where = '', $data = []){
    global $conn;

    $sql = "SELECT $columns FROM $table " . $where;
    $statement  = $conn->prepare($sql);
    $statement->execute($data);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function dbInsert($table, $columns, $values, $data){
    global $conn;

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    $statement  = $conn->prepare($sql);
    $statement->execute($data);
    $last = $conn->lastInsertId();

    return $last;
}

function dbUpdate($table, $values, $where, $data){
    global $conn;

    $sql = "UPDATE $table SET $values " . $where;
    $statement  = $conn->prepare($sql);
    $success = $statement->execute($data);

    return $success;
}

function dbDelete($table, $where, $data){
    global $conn;

    $sql = "DELETE FROM $table " . $where;
    $statement  = $conn->prepare($sql);
    $success = $statement->execute($data);

    return $success;
}