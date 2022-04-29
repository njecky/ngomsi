<?php
session_start();

$debug = 1;
$dbhost = 'localhost';
$dbname = 'franc';
$dbuser = 'root';
$dbpswd = 'root';

try {
	$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';',$dbuser,$dbpswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}catch (PDOException $e){
	if ($debug >=1){
                die($e->getMessage());
            }else{
                die("Une erreur est survenue lors de la connexion à la base de données");
            }
}

//$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);