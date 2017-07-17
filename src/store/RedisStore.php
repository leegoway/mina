<?php

namespace leegoway\mina\store;

class RedisStore implements StoreInterface
{
	private $redisComponent;
	private $prefix = 'mina';
	private $expireSeconds = 900;

	public function __construct($component, $expireSeconds = 900)
	{
		$this->redisComponent = $component;
		$this->expireSeconds = $expireSeconds;
	}

	public function store($sessionId, $sessionKey, $openId)
	{
		$this->redisComponent->hmset($this->prefix . $sessionId, 'openId', $openId, 'sessionKey', $sessionKey);
		$this->redisComponent->expire($this->prefix . $sessionId, $this->expireSeconds);
		return true;
	}

	public function get($sessionId)
	{
		$vals = $this->redisComponent->hmget($this->prefix . $sessionId, 'openId', 'sessionKey');
		return array('openId' => $vals[0], 'sessionKey' => $vals[1]);
	}
}