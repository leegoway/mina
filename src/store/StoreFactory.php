<?php

/*
 * Store工厂类
 */

namespace leegoway\mina\store;

use Yii;

class StoreFactory
{
	public static function getStoreHandler($config)
	{
		if(empty($config['handler'])){
			throw new \Exception('please set store handler class first');
		} elseif ($config['handler'] == 'redis') {
			$componentName = $config['component'];
			return new RedisStore(Yii::$app->$componentName, $config['expireSeconds']);
		} else {
			throw new \Exception('not supported handler:' . $config['handler']);
		}
	}
}