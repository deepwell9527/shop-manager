<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Contracts;

use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;

class AbstractApiClient
{
    protected AccessTokenAwareClient $client;

    public function setAccessTokenAwareClient(AccessTokenAwareClient $client): self
    {
        $this->client = $client;
        return $this;
    }
}