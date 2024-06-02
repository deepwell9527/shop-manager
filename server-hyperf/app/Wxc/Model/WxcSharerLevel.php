<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $id
 * @property int $site_id 租户ID
 * @property int $level_id 等级ID
 * @property string $title 等级名称
 * @property float $first_tier_rate 一级分销佣金比例，分享员直接销售获得佣金的比例
 * @property float $sec_tier_rate 二级分销佣金比例，分享员的下级的客户购买后获得佣金的比例
 * @property array $upgrade_criteria 升级条件
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcSharerLevel extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_sharer_level';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'site_id', 'level_id', 'title', 'first_tier_rate', 'sec_tier_rate', 'upgrade_criteria', 'created_at', 'updated_at'];

    protected array $attributes = [
        'upgrade_criteria' => '',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'site_id' => 'integer', 'level_id' => 'integer', 'first_tier_rate' => 'float', 'sec_tier_rate' => 'float', 'upgrade_criteria' => 'array', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected array $appends = [
        'desc'
    ];

    /**
     * 分佣比例描述
     * @return string
     */
    public function getDescAttribute(): string
    {
        $str = '';
        if (!empty($this->attributes['first_tier_rate'])) {
            $str .= '一级分佣比例：' . $this->attributes['first_tier_rate'] . '%';
        }
        if (!empty($this->attributes['sec_tier_rate'])) {
            $str .= '，二级分佣比例：' . $this->attributes['sec_tier_rate'] . '%';
        }
        return $str;
    }
}
