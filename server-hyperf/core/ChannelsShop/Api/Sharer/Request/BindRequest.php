<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer\Request;

use Deepwell\Data\Data;

class BindRequest extends Data
{

    /**
     * 邀请的用户微信号【为空时，获得的二维码可以邀请多个用户】
     */
    public string $username = '';
}