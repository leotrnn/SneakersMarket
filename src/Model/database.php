<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Classe qui connecte la base de données
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

require_once('./src/Model/config.php');

class Database
{

    private static $objInstance;

    private static function getInstance()
    {
        if (!self::$objInstance) {
            try {
                $dsn = EDB_DBTYPE . ':host=' . EDB_HOST . ';port=' . EDB_PORT . ';dbname=' . EDB_DBNAME;
                self::$objInstance = new PDO($dsn, EDB_USER, EDB_PASS, array('charset' => 'utf8'));
                self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Database error : " . $e;
            }
        }
        return self::$objInstance;
    }

    final public static function __callStatic($chrMethod, $arrArguments)
    {
        $objInstance = self::getInstance();
        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments);
    }
}