<?php
declare(strict_types=1);

namespace App\Wxc\Request;

use App\Wxc\Enums\DistributionType;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

/**
 * 分销设置保存请求
 */
class WxcDistributionSaveRequest extends Data
{
    public DistributionType $type;

    public bool|Optional $auto_upgrade;


    public static function attributes(): array
    {
        return [
            'type' => '分销模式',
            'auto_upgrade' => '自动升级',
        ];
    }
}