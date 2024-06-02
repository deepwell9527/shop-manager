<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer\Request;

use Deepwell\ChannelsShop\Api\Sharer\Enums\SharerType;
use Deepwell\Data\Attributes\MapName;
use Deepwell\Data\Attributes\WithCast;
use Deepwell\Data\Casts\EnumCast;
use Deepwell\Data\Data;
use Deepwell\Data\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class GetSharerListRequest extends Data
{
    /**
     * @param int $page 页码
     * @param int $pageSize 每页分享员数
     * @param SharerType $sharerType 分享员类型
     */
    public function __construct(
        public int        $page = 1,
        public int        $pageSize = 10,
        #[WithCast(EnumCast::class)]
        public SharerType $sharerType = SharerType::Normal,
    )
    {

    }
}