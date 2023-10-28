<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2014
 */
    class Conexion
    {
        //constantes para la conexion
        Static $usuario   = 'dbuser';
        static $clave     = 'dbpassword';
        //declaramos estática para que se acceda esta propiedad directamente desde el objeto
        static $link;
        
        // definimos el método constructor simplemente para que no se pueda instanciar
        private function __construct(){}
        
     /**
     * @static
     * @return PDO
     * declaramos estática para que se acceda este método directamente desde el objeto
     */
        static function conectar(){
            try {
                self::$link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=teccam;charset=utf8", self::$usuario, self::$clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                /*** nos conectamos ***/
                //echo 'conectado a mysql <br />'; 
                return self::$link;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }           
        }
        static function conectarLocal(){
            try {
                self::$link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=teccam;charset=utf8", self::$usuario, self::$clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                /*** nos conectamos ***/
                //echo 'conectado a mysql <br />'; 
                return self::$link;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }           
        }
        static function conectarServer(){
            try {
                self::$link = new PDO("mysql:host=127.0.0.1;port=3306;dbname=teccam;charset=utf8", self::$usuario, self::$clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                /*** nos conectamos ***/
                //echo 'conectado a mysql <br />'; 
                return self::$link;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }           
        }
       static function conectarCDR(){
            try {
                self::$link = new PDO("mysql:host=192.168.1.13;port=3306;dbname=cdr;charset=utf8", self::$usuario, self::$clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                /*** nos conectamos ***/
                //echo 'conectado a mysql <br />'; 
                return self::$link;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }           
        }
       static function conectarUY(){
            try {
                self::$link = new PDO("mysql:host=192.168.1.13;port=3306;dbname=uy;charset=utf8", self::$usuario, self::$clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                /*** nos conectamos ***/
                //echo 'conectado a mysql <br />'; 
                return self::$link;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }           
        }
    }

//$con = Conexion::conectar();
