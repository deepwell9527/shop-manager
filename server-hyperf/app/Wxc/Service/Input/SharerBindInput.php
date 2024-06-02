<?php
declare(strict_types=1);

namespace App\Wxc\Service\Input;

use Deepwell\Data\Attributes\MapInputName;
use Deepwell\Data\Data;
use Deepwell\Data\Mappers\SnakeCaseMapper;
use Deepwell\Data\Optional;

#[MapInputName(SnakeCaseMapper::class)]
class  SharerBindInput extends Data
{
    public function __construct(
        readonly public string          $appId,
        readonly public string|Optional $username
    )
    {
    }
}