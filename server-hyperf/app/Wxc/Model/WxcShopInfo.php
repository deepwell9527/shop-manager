<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $shop_id 系统店铺ID
 * @property int $site_id 租户ID
 * @property string $app_id 小店appid
 * @property string $nickname 店铺名称
 * @property string $headimg_url 店铺头像URL
 * @property string $subject_type 店铺类型，目前为"企业"或"个体工商户"
 * @property string $status 店铺状态，目前为"opening"或"open_finished"或"closing"或"close_finished"
 * @property string $username 店铺原始ID
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcShopInfo extends MineModel
{
    public bool $incrementing = false;
    protected string $primaryKey = 'shop_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_shop_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['shop_id', 'app_id', 'site_id', 'nickname', 'headimg_url', 'subject_type', 'status', 'username', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['shop_id' => 'integer', 'site_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
