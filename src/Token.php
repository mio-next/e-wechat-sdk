<?php
/**
 * Author: EnHe <info@wowphp.cn>
 * Date: 2018/8/6
 * Time: 下午8:19
 */

namespace Wow\EnterpriseWeChat;

use GuzzleHttp\Client;
use Wow\EnterpriseWeChat\WeChatException;

class Token
{
    /**
     * Cache file
     */
    const CACHE_FILE = 'token.bin';

    /**
     * @var
     */
    protected $corpId;

    /**
     * @var
     */
    protected $corpSecret;

    /**
     * @var int
     */
    protected $agentId;

    /**
     * Token constructor.
     * @param int $corpId
     */
    public function __construct($corpId)
    {
        $this->corpId = $corpId;
    }

    /**
     * @param mixed $corpSecret
     */
    public function setCorpSecret($corpSecret)
    {
        $this->corpSecret = $corpSecret;

        return $this;
    }

    /**
     * @param int $agentId
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getCorpId()
    {
        return $this->corpId;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getCorpSecret()
    {
        return $this->corpSecret;

        return $this;
    }

    /**
     * @return int
     */
    protected function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * @param bool $force
     * @return bool
     * @throws WeChatException
     */
    public function getAccessToken($force = false)
    {
        $accessToken = $this->getFromCache();

        return $accessToken ?: $this->getFromRemote();
    }

    /**
     * @return bool
     */
    private function getFromCache()
    {
        if (! file_exists($this->getCacheName())) return false;

        $cache = json_decode(
            file_get_contents($this->getCacheName()), true
        );

        if (! isset($cache['time']) || ! isset($cache['token'])) return false;

        if (time() > ((int) $cache['time'] + (int) $cache['token']['expires_in'])) {

            @file_put_contents($this->getCacheName(), '');

            return false;
        }

        return isset($cache['token']['access_token']) ? $cache['token']['access_token'] : '';
    }

    /**
     * @return mixed
     * @throws WeChatException
     */
    private function getFromRemote()
    {
        try
        {
            $api = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?" . http_build_query(
                    ['corpid' => $this->getCorpId(), 'corpsecret' => $this->getCorpSecret()]
                );

            $response = json_decode((new Client())->get($api)->getBody(), true);

            if ($response['errcode'] != 0) {

                throw new WeChatException($response['errmsg']);
            }

            return $this->save2Cache($response);
        }

        catch (\Exception $exception) {

            throw new WeChatException($exception->getMessage());
        }
    }

    /**
     * @param array $token
     * @return mixed
     */
    private function save2Cache(array $token)
    {
        if (! file_exists($this->getCacheName())) {
            @touch($this->getCacheName());
        }

        if (file_exists($this->getCacheName())) {
            @file_put_contents($this->getCacheName(), json_encode(['time' => time(), 'token' => $token]));
        }

        return $token['access_token'];
    }

    /**
     * @return string
     */
    private function getCacheName()
    {
        return $this->getCorpId() . "-" . $this->getAgentId() . "-" . self::CACHE_FILE;
    }
}