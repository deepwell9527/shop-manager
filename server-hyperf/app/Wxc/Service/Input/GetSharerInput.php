<?php

declare(strict_types=1);

namespace App\Wxc\Service\Input;

use Deepwell\Contract\AbstractQueryInput;
use Deepwell\Data\Optional;

class GetSharerInput extends AbstractQueryInput
{
    public int|Optional $sharer_id;

    public string|Optional $openid;
}