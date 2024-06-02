<?php
declare(strict_types=1);

namespace App\Wxc\Request;

use Deepwell\Data\Attributes\Validation\ArrayType;
use Deepwell\Data\Attributes\Validation\Between;
use Deepwell\Data\Attributes\Validation\Decimal;
use Deepwell\Data\Attributes\Validation\RequiredIf;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class WxcProductSaveRequest extends Data
{
    /**
     * 商品ID
     * @var array<int>
     */
    #[ArrayType]
    public array $product_id_list;

    /**
     * 是否开启商品佣金
     */
    public bool|Optional $use_commission;

    /**
     * 佣金比例
     */
    #[RequiredIf('use_commission', '1'), Decimal(0, 2), Between(0.00, 99.99)]
    public float $commission_rate;


    public static function attributes(): array
    {
        return [
            'use_commission' => '商品佣金开关',
            'commission_rate' => '佣金比例',
        ];
    }

    public static function messages(): array
    {
        return [
            'commission_rate.decimal' => '佣金比例最多能设置两位小数',
        ];
    }
}