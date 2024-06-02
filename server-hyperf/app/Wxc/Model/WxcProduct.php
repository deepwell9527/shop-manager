<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\HasOne;
use Mine\MineModel;

/**
 * @property int $product_id 商品ID
 * @property int $site_id
 * @property string $app_id
 * @property string $title 标题
 * @property string $cats 分类
 * @property string $head_imgs 主图列表string[]
 * @property int $status 状态
 * @property int $edit_status 草稿状态
 * @property int $min_price 商品SKU最小价格
 * @property int $max_price 商品SKU最大价格
 * @property Carbon $edit_time 最近修改时间
 * @property Carbon $synced_at 最近同步时间
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property WxcProductSpec $spec
 */
class WxcProduct extends MineModel
{
    public bool $incrementing = false;

    protected string $primaryKey = 'product_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_product';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['product_id', 'site_id', 'app_id', 'title', 'cats', 'head_imgs', 'status', 'edit_status', 'min_price', 'max_price', 'edit_time', 'synced_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['product_id' => 'integer', 'site_id' => 'integer', 'status' => 'integer', 'edit_status' => 'integer', 'min_price' => 'integer', 'max_price' => 'integer', 'head_imgs' => 'array', 'edit_time' => 'datetime', 'synced_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected array $appends = [
        'cats_desc',
    ];

    /**
     * 商品自定义信息
     * @return HasOne
     */
    public function spec(): HasOne
    {
        return $this->hasOne(WxcProductSpec::class, 'product_id', 'product_id');
    }

    protected function getCatsDescAttribute(): string
    {
        if (!empty($this->attributes['cats'])) {
            $cats = WxcCategory::whereIn('category_id', explode(',', $this->attributes['cats']))->pluck('title');
            return $cats->implode('/');
        }
        return '';
    }
}
