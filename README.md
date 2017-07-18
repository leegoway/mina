# mina
PHP mina login 小程序登录 PHP composer 包

##使用方法
---

### 基础使用

    使用SessionService类调用微信小程序接口，获取sessionKey和openId

```php
use leegoway\mina\SessionService;

$code = 'your code';//小程序本次回话code
$config = ['appid' => 'your appid', 'appsecret' => 'your appsecret'];//小程序配置
$sessionService = new SessionService($config);

$sessionInfo = $sessionService->getSessionId($code);
//return ['sessionId' => '', 'sessionKey' => '', 'openId' => ''];
```

### 作为Yii2的component使用
```php
return [
    'components' => [
        'minaAuth' => [
            'class' => 'leegoway\mina\MinaFacade',
            'appid' => 'your appid',
            'appsecret' => 'your appsecret',
            'storeconfig' => [
            	'driver' => 'redis',   //存储类型
            	'component' => 'redis', //yii2的component
            	'expireSeconds' => 900, //session有效时间
            ], 
        ]
    ],
];
```

```php

$code = 'your code';//小程序本次回话code 
$sessionInfo = Yii::$app->minaAuth->getSessionInfo($code);
//return ['sessionId' => '', 'sessionKey' => '', 'openId' => ''];
$openId = Yii::$app->minaAuth->getOpenId($sessionInfo['sessionId']);
//return openid
$sessionKey = Yii::$app->minaAuth->getSessionKey($sessionInfo['sessionId']);
//return sessionKey
```