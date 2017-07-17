<?php

/*
 * 小程序登录相关的session信息
 */

namespace leegoway\mina;

use GuzzleHttp\Client;

class SessionService 
{

	//小程序登录地址
	private $url = 'https://api.weixin.qq.com/sns/jscode2session?';

	//小程序appid
	private $appid = 'your appid';

	//小程序appsecret
	private $appsecret = 'your appsecret';

	//小程序sessionid的名字
	private $sessionKey = 'minaSessionid';

	private $timeout = 5;

	//构造方法，传递设置进行初始化
	public function __construct($config = [])
	{
		if (isset($config['url'])){
			$this->url = $config['url'];
		}
		if (isset($config['appid'])){
			$this->appid = $config['appid'];
		}
		if (isset($config['appsecret'])){
			$this->appsecret = $config['appsecret'];
		}
		if (isset($config['sessionKey'])){
			$this->sessionKey = $config['sessionKey'];
		}
	}

	//获取可配置的sessionId的名字
	public function getSessionKey()
	{
		return $this->sessionKey;
	}

	//获取微信的session值
	public function getSessionId($code)
	{
		$query = 'appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
		$client = new Client(['timeout' => $this->timeout]);
		$response = $client->request('GET', $this->url . sprintf($query, $this->appid, $this->appsecret, $code));
		if ($response->getStatusCode() != 200){
			return null;
		}
		$body = $response->getBody();
		$reqData = json_decode($body, true);
		if (!isset($reqData['session_key'])) {
            return null;
        }
        $sessionKey = $reqData['session_key'];
        $openId = $reqData['openid'];
        $sessionId = $this->generate_secret_key();
        return array('sessionId' => $sessionId, 'sessionKey' => $sessionKey, 'openId' => $openId);
	}

	/**
	 * Generates a 16 digit secret key in base32 format
	 * @return string
	 **/
	public static function generate_secret_key($length = 16) {
		$b32 	= "234567QWERTYUIOPASDFGHJKLZXCVBNM";
		$s 	= "";

		for ($i = 0; $i < $length; $i++)
			$s .= $b32[rand(0,31)];

		return $s;
	}
}