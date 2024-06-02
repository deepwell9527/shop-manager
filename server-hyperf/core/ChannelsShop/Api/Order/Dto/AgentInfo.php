<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

/**
 * 授权账号信息类
 */
class AgentInfo extends Data
{
    /**
     * 授权视频号id
     * @var string
     */
    public string $agent_finder_id;

    /**
     * 授权视频号昵称
     * @var string
     */
    public string $agent_finder_nickname;
}