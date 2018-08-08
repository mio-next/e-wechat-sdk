<?php
/**
 * Author: EnHe <info@wowphp.cn>
 * Date: 2018/8/7
 * Time: 上午10:58
 */

namespace Wow\EnterpriseWeChat\Messages;


/**
 * Class Message
 * @package Wow\EnterpriseWeChat\Messages
 */
abstract class Message
{
    /**
     * @var
     */
    private $token;

    /**
     * @var
     */
    private $users = '';

    /**
     * @var
     */
    private $parties = '';

    /**
     * @var
     */
    private $tags = '';

    /**
     * @var string
     */
    protected $msgType = 'text';

    /**
     * @var
     */
    protected $agentId;

    /**
     * @return mixed
     */
    protected function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    protected function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    protected function getParties()
    {
        return $this->parties;
    }

    /**
     * @return mixed
     */
    protected function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    protected function getMsgType()
    {
        return $this->msgType;
    }

    /**
     * @return mixed
     */
    protected function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * @return mixed
     */
    abstract public function send();

    /**
     * @param array $users
     * @return $this
     */
    public function setUsers(array $users)
    {
        $this->users = implode('|', $users);

        return $this;
    }

    /**
     * @param array $parties
     * @return $this
     */
    public function setParties(array $parties)
    {
        $this->parties = implode('|', $parties);

        return $this;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function setTags(array $tags)
    {
        $this->tags = implode('|', $tags);

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setMessageType($type)
    {
        $this->msgType = $type;

        return $this;
    }

    /**
     * @param int $agentId
     * @return $this
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return array
     */
    protected function getBody()
    {
        return [
            'touser'    => $this->getUsers(),
            'toparty'   => $this->getParties(),
            'totag'     => $this->getTags(),
            'msgtype'   => $this->getMsgType(),
            'agentid'   => $this->getAgentId(),
            'safe'      => 0
        ];
    }
}