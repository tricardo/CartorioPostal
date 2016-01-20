<?php
$script_version="3.1";
$unsub_email_path=$dirpath."unsub.php"; 
$sub_path=$dirpath."subscribe.php"; 
$script_mode="live"; 
error_reporting(0);
if(include_once("../inoutsql.php")){$script_mode="demo"; }else {$script_mode="live";}
//MYSQL Class
if($script_mode=="demo")
include("../inoutsql.php");
include("mysql.cls.php");

include("paging.cls.php"); 
$paging=new paging();
if($tableprefix!="")
$tableprefix.="_";
?>
