<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace utils;


class Aes7 {

    public $key = '';
    public $iv = '';

    public function __construct($config) {
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
    }

    //加密
    public function aesEn($data) {
        $data = openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv);

        $data = strtolower(bin2hex($data));

        return $data;
    }

    //解密
    public function aesDe($data) {

        return openssl_decrypt(hex2bin($data), $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv);
    }

}


/*
$config = [
    'key' => '1234567890123458', //加密key 
    //  'iv' => md5(time() . uniqid(), true), //保证偏移量为16位
    'iv' => NULL, //保证偏移量为16位
    'method' => 'AES-128-ECB' //加密方式  # AES-256-CBC等 ECB模式不用设置iv
];

$obj = new Aes7($config);

$res = $obj->aesEn('99999999'); //加密数据

echo $res;
echo '<hr>';

echo $obj->aesDe($res); //解密
 
 * 
 * 
 */