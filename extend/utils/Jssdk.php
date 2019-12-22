<?php

namespace utils;

/**
 * @title 微信公众号开发
 */
class Jssdk {

    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {



        $data = array();

        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        if (is_file("jsapi_ticket.json")) {
            $data = json_decode(file_get_contents("jsapi_ticket.json"), true);
        }


        if ($data && $data['expire_time'] > time()) {
            $ticket = $data['jsapi_ticket'];
        } else {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url), true);

            $ticket = $res['ticket'];
            if ($ticket) {
                $data['expire_time'] = time() + 7000;
                $data['jsapi_ticket'] = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        }

 


        return $ticket;
    }

    /**
     * 获取用户的openid 
     * @param  string $openid [description] 
     * @return [type]         [description] 
     */
    public function getOpenID($redirect_url, $base_info = true) {

        //1.准备scope为snsapi_base网页授权页面  
        $baseurl = urlencode($redirect_url);


        
        $scope = $base_info ? 'snsapi_base': 'snsapi_userinfo';

        $snsapi_base_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appId=' . $this->appId . '&redirect_uri=' . $baseurl . '&response_type=code&scope='.$scope.'&state=YQJ#wechat_redirect';



        // print_r($snsapi_base_url);exit;
        //2.静默授权,获取code  
        //页面跳转至redirect_uri/?code=CODE&state=STATE  
        //$code = input('get.code', '');
        if (!isset($_GET['code'])) {

            //file_put_contents('tttt.txt', $snsapi_base_url);

            header('Location:' . $snsapi_base_url);

            exit;
        } else {


            $code = $_GET['code'];

            //3.通过code换取网页授权access_token和openid  
            $curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appId=' . $this->appId . '&secret=' . $this->appSecret . '&code=' . $code . '&grant_type=authorization_code';
            $content = $this->httpGet($curl);
            $result = json_decode($content, true);

            return $result;
        }
    }

    public function getAccessToken() {


        $data = array();

        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        if (is_file("access_token.json")) {
            $data = json_decode(file_get_contents("access_token.json"), true);
        }

        //$data = json_decode(file_get_contents("access_token.json"));
        if ($data && $data['expire_time'] > time()) {

            $access_token = $data['access_token'];
        } else {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url), true);


            if (isset($res['errcode'])) {
                exit($res['errmsg']);
            }
            //print_r($res);
            //exit;

            $access_token = $res['access_token'];
            if ($access_token) {
                $data['expire_time'] = time() + 7000;
                $data['access_token'] = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

}
