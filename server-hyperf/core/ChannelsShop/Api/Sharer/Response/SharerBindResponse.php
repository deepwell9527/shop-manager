<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Sharer\Response;

use Deepwell\ChannelsShop\Contracts\AbstractResponse;
use Deepwell\Data\Attributes\MapInputName;
use Deepwell\Data\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SharerBindResponse extends AbstractResponse
{
    /**
     * 邀请二维码的图片二进制，15天有效
     */
    public string $qrcodeImg;

    /**
     * 邀请二维码的图片二进制base64编码，15天有效
     */
    public string $qrcodeImgBase64;
}