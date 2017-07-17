<?php

/*
 * Store存储接口
 */

namespace leegoway\mina\store;

interface StoreInterface
{
	public function store($sessionId, $openId, $sessionKey);//存储
	public function get($sessionId);//获取
}