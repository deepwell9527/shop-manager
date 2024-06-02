<?php

declare(strict_types=1);

namespace Deepwell\ChannelsShop;

class AccessToken extends \EasyWeChat\OfficialAccount\AccessToken
{
    const string CACHE_KEY_PREFIX = 'channels_shop';
}
