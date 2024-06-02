<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer\Response;

use Deepwell\ChannelsShop\Api\Sharer\Dto\SharerInfo;
use Deepwell\ChannelsShop\Contracts\AbstractResponse;
use Deepwell\Data\Attributes\MapInputName;
use Deepwell\Data\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SharerListResponse extends AbstractResponse
{
    /**
     * 分享员信息列表
     * @var SharerInfo[]
     */
    public array $sharerInfoList;
}