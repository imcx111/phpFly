<?php

namespace utils;

/**
 * 微信小程序用户管理类
 * Class WxUser
 * @package app\common\library\wechat
 */

use utils\Jssdk;
use think\Cookie;
use think\Cache;
use think\Config;

class WxUser
{
    private $appId;
    private $appSecret;

    private $error;

    /**
     * 构造方法
     * WxUser constructor.
     * @param $appId
     * @param $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * 获取session_key
     * @param $code
     * @return array|mixed
     */
    public function sessionKey($code)
    {
        /**
         * code 换取 session_key
         * ​这是一个 HTTPS 接口，开发者服务器使用登录凭证 code 获取 session_key 和 openid。
         * 其中 session_key 是对用户数据进行加密签名的密钥。为了自身应用安全，session_key 不应该在网络上传输。
         */
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $result = json_decode(curl($url, [
            'appId' => $this->appId,
            'secret' => $this->appSecret,
            'grant_type' => 'authorization_code',
            'js_code' => $code
        ]), true);
        if (isset($result['errcode'])) {
            $this->error = $result['errmsg'];
            return false;
        }
        return $result;
    }

    public function getError()
    {
        return $this->error;
    }
    
    
    
    
    /**
     * @title 获取微信用户信息
     */
    public function getWxUserInfo($wx_login_url) {




        //微信标记（自己创建的）
        $wxKey = Cookie::get('wxKey');

        //先看看本地cookie里是否存在微信唯一标记，
        //假如存在，可以通过$wxKey到redis里取出微信个人信息（因为在第一次取到微信个人信息，我会将其保存一份到redis服务器里缓存着）
        if (!empty($wxKey)) {

            //如果存在，则从Redis里取出缓存了的数据
            $userInfo = Cache::get("weixin:sign_{$wxKey}");

            if (!empty($userInfo)) {
                return $userInfo;
            }
        }





        //如果缓存不存在
        $jssdk = new Jssdk($this->appId, $this->appSecret);
        $openid_array = $jssdk->getOpenID($wx_login_url, false);


        // print_r($openid_array);exit;


        if (!isset($openid_array['openid'])) {
            // exit('获取openid失败');
            print_r($openid_array);
            exit;
        }



        //$userInfo = $this->getUserInfo1($openId, $accessToken);
        $userInfo = $this->getUserInfo2($openid_array['openid'], $openid_array['access_token']);



        if (isset($userInfo['errcode'])) {
            exit($userInfo['errcode']);
        }


        //自定义微信唯一标识符
        $wxKey = substr(md5($openid_array['openid'] . 'seqier'), 8, 16);
        //将其存到cookie里
        Cookie::set('wxKey', $wxKey, 60 * 60 * 24 * 1);
        //将个人信息缓存到redis里
        Cache::set("weixin:sign_{$wxKey}", $userInfo, 60 * 60 * 24 * 1);


        return $userInfo;
    }

    /**
     * @title 第一种获取用户信息的方式
     * @param type $openId
     * @param type $accessToken
     * @return type
     */
    public function getUserInfo1($openId, $accessToken) {

        //全局access token获得用户基本信息
        $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$openId";
        $userinfo_json = https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, true);
        return $userinfo_array;
    }

    /**
     * @title 第二种获取用户信息的方式 
     * @param type $openId
     * @param type $accessToken
     * @return type
     */
    public function getUserInfo2($openId, $accessToken) {

        //全局access token获得用户基本信息
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$accessToken&openid=$openId";
        $userinfo_json = https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, true);
        return $userinfo_array;
    }

}