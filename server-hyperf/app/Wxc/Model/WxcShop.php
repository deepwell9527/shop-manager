<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $shop_id
 * @property string $app_id 小店id
 * @property string $secret 小店密钥
 * @property string $token 消息校验令牌
 * @property string $aes_key 消息密钥
 * @property int $is_verified 接口连通性是否已验证
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcShop extends MineModel
{
    protected string $primaryKey = 'shop_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_shop';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['shop_id', 'site_id', 'app_id', 'secret', 'token', 'aes_key', 'is_verified', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['shop_id' => 'integer', 'site_id' => 'integer', 'is_verified' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected array $attributes = [
        'is_verified' => 0
    ];
}
