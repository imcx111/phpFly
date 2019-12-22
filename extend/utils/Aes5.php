<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace utils;


class Aes5 {

    public static function encrypt($input, $key) {
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $paddedData = static::pkcs5_pad($input, $blockSize);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        
      //  echo $iv;exit;
        
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $paddedData, MCRYPT_MODE_ECB, $iv);
        return bin2hex($encrypted);
    }

    private static function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function decrypt($sStr, $key) {
        $decrypted = mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128, $key, hex2bin($sStr), MCRYPT_MODE_ECB
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    /**
     * url 安全的base64编码 sunlonglong
     */
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * url 安全的base64解码 sunlonglong
     */
    function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

}

//$key = '1234567890123458';
//$encrypt = Aes5::encrypt('99999999', $key);
//$decrypt = Aes5::decrypt($encrypt, $key);
//var_dump($encrypt, $decrypt);
