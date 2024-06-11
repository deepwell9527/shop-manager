<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\hasOne;
use Mine\MineModel;

/**
 * @property int $sharer_id
 * @property int $site_id
 * @property string $app_id
 * @property string $openid 分享员openid
 * @property string $nickname 分享员昵称
 * @property string $bind_time 绑定时间
 * @property int $sharer_type 分享员类型。0：普通，1：店铺
 * @property string $unionid 分享员unionid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property WxcShop $shop
 * @property WxcSharerSpec $spec
 */
class WxcSharer extends MineModel
{
    protected string $primaryKey = 'sharer_id';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_sharer';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['sharer_id', 'site_id', 'app_id', 'openid', 'nickname', 'bind_time', 'sharer_type', 'unionid', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['sharer_id' => 'integer', 'site_id' => 'integer', 'sharer_type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 定义 shop 关联
     * @return hasOne
     */
    public function shop(): hasOne
    {
        return $this->hasOne(WxcShop::class, 'app_id', 'app_id');
    }

    /**
     * 分享员自定义信息
     * @return HasOne
     */
    public function spec()
    {
        return $this->hasOne(WxcSharerSpec::class, 'sharer_id', 'sharer_id');
    }

    public function parent()
    {
        return $this->hasOneThrough(WxcSharer::class, WxcSharerSpec::class, 'sharer_id', 'sharer_id', 'sharer_id', 'pid');
    }
}
