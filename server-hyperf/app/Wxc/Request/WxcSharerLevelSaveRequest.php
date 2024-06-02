<?php
declare(strict_types=1);

namespace App\Wxc\Request;

use Deepwell\Data\Attributes\Validation\Between;
use Deepwell\Data\Attributes\Validation\Decimal;
use Deepwell\Data\Attributes\Validation\Max;
use Deepwell\Data\Data;

class WxcSharerLevelSaveRequest extends Data
{
    /**
     * @var string 等级名称
     */
    #[Max(20)]
    public string $title;

    /**
     * @var float 一级分销佣金比例
     */
    #[Decimal(0, 2), Between(0.00, 99.99)]
    public float $first_tier_rate;

    /**
     * @var float 二级分销佣金比例
     */
    #[Decimal(0, 2), Between(0.00, 99.99)]
    public float $sec_tier_rate;

    public static function attributes(): array
    {
        return [
            'title' => '等级名称',
            'first_tier_rate' => '一级分销佣金比例',
            'sec_tier_rate' => '二级分销佣金比例',
        ];
    }

    public static function messages(): array
    {
        return [
            'first_tier_rate.decimal' => '佣金比例最多能设置两位小数',
            'sec_tier_rate.decimal' => '佣金比例最多能设置两位小数',
        ];
    }
}