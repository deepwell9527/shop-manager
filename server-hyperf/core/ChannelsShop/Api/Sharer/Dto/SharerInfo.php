<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer\Dto;

use Carbon\Carbon;
use Deepwell\ChannelsShop\Api\Sharer\Enums\SharerType;
use Deepwell\Data\Attributes\MapInputName;
use Deepwell\Data\Attributes\WithCast;
use Deepwell\Data\Casts\DateTimeInterfaceCast;
use Deepwell\Data\Casts\EnumCast;
use Deepwell\Data\Data;
use Deepwell\Data\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SharerInfo extends Data
{
    /**
     * 分享员openid
     */
    public string $openid;

    /**
     * 分享员昵称
     */
    public string $nickname;

    /**
     * 绑定时间
     */
    #[WithCast(DateTimeInterfaceCast::class)]
    public Carbon $bindTime;

    /**
     * 分享员类型
     */
    #[WithCast(EnumCast::class)]
    public SharerType $sharerType;

    /**
     * 分享员unionid
     */
    public string $unionid;
}