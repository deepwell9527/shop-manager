<?php
declare(strict_types=1);

namespace App\Wxc\Request;

use App\Wxc\Enums\RateMode;
use Deepwell\Data\Attributes\Validation\ArrayType;
use Deepwell\Data\Attributes\Validation\Between;
use Deepwell\Data\Attributes\Validation\Decimal;
use Deepwell\Data\Attributes\Validation\Exists;
use Deepwell\Data\Attributes\Validation\RequiredIf;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class WxcSharerSaveRequest extends Data
{
    /**
     * @var array<int> 分享员ID
     */
    #[ArrayType]
    public array $sharer_id_list;

    /**
     * 分享员上级ID
     */
    #[Exists('wxc_sharer', 'sharer_id')]
    public int|Optional $parent_sharer_id;

    /**
     * 佣金比例模式
     */
    public RateMode|Optional $rate_mode;

    /**
     * 一级分佣比例
     */
    #[RequiredIf('rate_mode', RateMode::Custom), Decimal(0, 2), Between(0.00, 99.99)]
    public float|Optional $first_tier_rate;

    /**
     * 二级分佣比例
     */
    #[Decimal(0, 2), Between(0.00, 99.99)]
    public float|Optional $sec_tier_rate;

    /**
     * 等级ID
     */
    #[RequiredIf('rate_mode', RateMode::Default), Exists('wxc_sharer_level')]
    public int|Optional $level_id;

    /**
     * 提现手续费
     */
    #[Decimal(0, 2), Between(0.00, 99.99)]
    public float|Optional $withdrawal_fee;

    /**
     * 下单锁客
     */
    public bool|Optional $is_order_lock;

    /**
     * 锁客失效时间
     */
    #[RequiredIf('is_order_lock', '1')]
    public int $lock_expires_in;

    /**
     * 自购返佣
     */
    public bool|Optional $is_rebate;

    public static function attributes(): array
    {
        return [
            'first_tier_rate' => '一级分佣比例',
            'sec_tier_rate' => '二级分佣比例',
        ];
    }

    public static function messages(): array
    {
        return [
            'first_tier_rate.decimal' => '分佣比例最多能设置两位小数',
            'sec_tier_rate.decimal' => '分佣比例最多能设置两位小数',
        ];
    }
}