# 企业微信SDK

- 目前正在开发中， 由于工作所需目前只实现了文字消息发送.. 后续有时间继续完善。

```php
tests/test.php

require __DIR__ . '/../vendor/autoload.php';

use Wow\EnterpriseWeChat\Messages\Text;
use Wow\EnterpriseWeChat\Connection\Token;

$token = (new Token('企业ID'))
    ->setAgentId('应用ID')
    ->setCorpSecret('应用安全码')
    ->getAccessToken();

$result = (new Text())
    ->setToken($token)
    ->setAgentId('应用ID')
    ->setUsers(['用户1', '用户2'])
    ->setMessage("测试消息， 更多请<a href='http://demo.cssmoban.com/cssthemes5/twts_51_unapp/index.html'>点击</a>查看")
    ->send();

var_dump($result);

```