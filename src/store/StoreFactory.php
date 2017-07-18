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
		if(empty($config['driver'])){
			throw new \Exception('please set store driver class first');
		} elseif ($config['driver'] == 'redis') {
			$componentName = $config['component'];
			return new RedisStore(Yii::$app->$componentName, $config['expireSeconds']);
		} else {
			throw new \Exception('not supported driver:' . $config['driver']);
		}
	}
}