<?php

namespace leegoway\mina;

use yii\base\Component;
use Yii;
use leegoway\mina\store\StoreFactory;

class MinaFacade extends Component
{

	public $appid = 'your appid';

	public $appsecret = 'your appsecret';

	//存储相关配置
	public $storeconfig = [];

	//存储处理类
	private $storeHandler;
	//跟微信交互获取session信息
	private $sessionService;

	public function init()
	{
		parent::init();
		$this->storeHandler = StoreFactory::getStoreHandler($this->storeconfig);
		$this->sessionService = new SessionService(['appid' => $this->appid, 'appsecret' => $this->appsecret]);
	}

	public function getSessionId($code) 
	{
		$sessionInfo = $this->sessionService->getSessionId($code);
		if ( 3 == count($sessionInfo) ) {
			$this->storeHandler->store($sessionInfo['sessionId'], $sessionInfo['sessionKey'], $sessionInfo['openId']);
		} else {
			throw new \Exception('获取session值失败');
		}
	}

	public function getOpenId($sessionId)
	{
		$info = $this->storeHandler->get($sessionId);
		return $info['openId'];
	}

}