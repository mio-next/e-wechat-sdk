<?php

require __DIR__ . '/../vendor/autoload.php';

use Wow\EnterpriseWeChat\Token;
use Wow\EnterpriseWeChat\Messages\Text;

$token = (new Token('ww6da54e63b033f6d4'))
    ->setAgentId(1000003)
    ->setCorpSecret('OIob3DgZzCDtSemIqlzWkbJifc_qFasgs0_f5m44ikU')
    ->getAccessToken();

$result = (new Text())
    ->setToken($token)
    ->setAgentId(1200009)
    ->setUsers(['enhe'])
    ->setMessage("测试消息， 更多请<a href='http://demo.cssmoban.com/cssthemes5/twts_51_unapp/index.html'>点击</a>查看")
    ->send();

var_dump($result);
