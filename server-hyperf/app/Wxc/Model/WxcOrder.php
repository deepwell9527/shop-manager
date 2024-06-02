<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\hasMany;
use Hyperf\Database\Model\Relations\hasOne;
use Mine\MineModel;

/**
 * @property int $order_id 订单ID
 * @property int $site_id 租户ID
 * @property string $app_id 视频号小店ID
 * @property int $status 订单状态
 * @property string $openid 买家身份标识
 * @property string $unionid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcOrder extends MineModel
{
    protected string $primaryKey = 'order_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_order';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_id', 'site_id', 'app_id', 'status', 'openid', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_id' => 'integer', 'site_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 定义 deliveryInfo 关联
     * @return hasOne
     */
    public function deliveryInfo(): hasOne
    {
        return $this->hasOne(WxcOrderDeliveryInfo::class, 'order_id', 'order_id');
    }

    /**
     * 定义 extInfo 关联
     * @return hasOne
     */
    public function extInfo(): hasOne
    {
        return $this->hasOne(WxcOrderExtInfo::class, 'order_id', 'order_id');
    }

    /**
     * 定义 payInfo 关联
     * @return hasOne
     */
    public function payInfo(): hasOne
    {
        return $this->hasOne(WxcOrderPayInfo::class, 'order_id', 'order_id');
    }

    /**
     * 定义 priceInfo 关联
     * @return hasOne
     */
    public function priceInfo(): hasOne
    {
        return $this->hasOne(WxcOrderPriceInfo::class, 'order_id', 'order_id');
    }

    /**
     * 定义 productInfos 关联
     * @return hasMany
     */
    public function productInfos(): hasMany
    {
        return $this->hasMany(WxcOrderProductInfo::class, 'order_id', 'order_id');
    }

    /**
     * 定义 sharerInfos 关联
     * @return hasMany
     */
    public function sharerInfos(): hasMany
    {
        return $this->hasMany(WxcOrderSharerInfo::class, 'order_id', 'order_id');
    }
}
