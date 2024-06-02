<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $product_id 商品ID
 * @property int $site_id 租户ID
 * @property string $app_id 小店ID
 * @property string $use_commission 是否开启商品佣金
 * @property float $commission_rate 分佣比例
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 */
class WxcProductSpec extends MineModel
{
    protected string $primaryKey = 'product_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_product_spec';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['product_id', 'site_id', 'app_id', 'use_commission', 'commission_rate', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['product_id' => 'integer', 'site_id' => 'integer', 'commission_rate' => 'float', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
