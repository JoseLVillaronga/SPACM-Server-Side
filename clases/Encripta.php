<?php
/**
 * @Author : José Luis Villaronga
 * @copyright : 2014
 */
class Encripta{
 
    private static $Key = "P0a1S2s3W4o5r6d7";
 
    public static function encrypt ($input) {
        $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encripta::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encripta::$Key))));
        return $output;
    }
 
    public static function decrypt ($input) {
        $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Encripta::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Encripta::$Key))), "\0");
        return $output;
    }
 
}