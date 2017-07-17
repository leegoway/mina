<?php

namespace leegoway\mina\store;

class RedisStore impliments StoreInterface
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
		$this->redisComponent->hmset($this->prefix . $sessionId, array('openId' =>$openId, 'sessionKey' => $sessionKey]));
		$this->redisComponent->expire($this->prefix . $sessionId, $this->expireSeconds);
		return true;
	}

	public function get($sessionId)
	{
		return $this->redisComponent->hmget($this->prefix . $sessionId);
	}
}