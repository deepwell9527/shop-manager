<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\HasOne;
use Mine\MineModel;

/**
 * @property int $sharer_id 分享员ID
 * @property int $pid 上级分享员ID
 * @property int $site_id 租户ID
 * @property string $mobile_number 手机号
 * @property int $rate_mode 1：默认（使用商品或等级的分佣比例），2：自定义（使用本表中的比例）
 * @property float $first_tier_rate 一级分佣比例，0.01~99.99，百分比值
 * @property float $sec_tier_rate 二级分佣比例
 * @property int $level_id 等级身份ID
 * @property float $withdrawal_fee 提现手续费，0.01~99.99，百分比值
 * @property string $is_order_lock 下单锁客
 * @property int $lock_expires_in 锁客失效时间，锁客失效时间，将在多少秒内失效
 * @property string $is_rebate 自购返佣
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property WxcSharerLevel $levelInfo 等级身份信息
 */
class WxcSharerSpec extends MineModel
{
    protected string $primaryKey = 'sharer_id';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_sharer_spec';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['sharer_id', 'pid', 'site_id', 'mobile_number', 'rate_mode', 'first_tier_rate', 'sec_tier_rate', 'level_id', 'withdrawal_fee', 'is_order_lock', 'lock_expires_in', 'is_rebate', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['sharer_id' => 'integer', 'pid' => 'integer', 'site_id' => 'integer', 'rate_mode' => 'integer', 'first_tier_rate' => 'float', 'sec_tier_rate' => 'float', 'level_id' => 'integer', 'withdrawal_fee' => 'float', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function levelInfo(): HasOne
    {
        return $this->hasOne(WxcSharerLevel::class, 'level_id', 'level_id');
    }
}
