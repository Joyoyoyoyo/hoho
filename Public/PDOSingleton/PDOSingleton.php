<?php
namespace PDOSingleton;

class PDOSingleton{
    private static $pdo;
    private static function initPDO(){
        self::$pdo=new \PDO('mysql://host=localhost;dbname=phpdao;charset=utf8', 'root', '', array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    }
    public static function getPDO(){ 
        if(isset(self::$pdo)){
            return self::$pdo;
        }else{
           self::initPDO();
           return self::$pdo;
        }
    }
}
