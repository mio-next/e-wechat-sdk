<?php
/**
 * Author: EnHe <info@wowphp.cn>
 * Date: 2018/8/7
 * Time: 上午10:54
 */

namespace Wow\EnterpriseWeChat\Messages;


use GuzzleHttp\Client;
use Wow\EnterpriseWeChat\WeChatException;

class Text extends Message
{
    /**
     * @var
     */
    protected $message;

    /**
     * @return mixed
     * @throws WeChatException
     */
    public function send()
    {
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/message/send?' . http_build_query(['access_token' => $this->getToken()]);

        try
        {
            $options = array_merge($this->getBody(), ['text' => ['content' => $this->getMessage()]]);

            $response = json_decode(
                (new Client())->request('POST', $api, ['json' => $options])->getBody(), true
            );

            return $response;
        }

        catch (\Exception $exception)
        {
            throw new WeChatException($exception->getMessage());
        }
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message = 'hi')
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}