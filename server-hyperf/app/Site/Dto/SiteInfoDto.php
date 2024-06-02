<?php
declare(strict_types=1);

namespace App\Site\Dto;

use Deepwell\Data\Attributes\MapName;
use Deepwell\Data\Dto;
use Deepwell\Data\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class SiteInfoDto extends Dto
{
    public string $uuid;

    public string $siteId;
}