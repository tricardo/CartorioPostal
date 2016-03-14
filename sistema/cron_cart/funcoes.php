<?
ini_set("session.cache_expire",3600);
session_start();

function __autoload($classe) {
    $dir = preg_match('/^([A-Z][a-z]+)DAO/i', $classe, $result);
    if (is_file("../model/" . $result[1] . "DAO.php")) {
        require_once("../model/" . $result[1] . "DAO.php");
        return;
    } else {
        $dir = preg_match('/^([A-Z][a-z]+)CLASS/i', $classe, $result);
        if (is_file("../classes/" . $result[1] . "CLASS.php")) {
            require_once("../classes/" . $result[1] . "CLASS.php");
            return;
        }
    }
}


require_once('../includes/classQuery.php');
require_once('../model/Database.php'); ?>