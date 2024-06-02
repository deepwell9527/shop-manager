<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $id 主键
 * @property int $site_id 租户Id
 * @property int $type 分销模式。1：一级；2：二级；3：多级
 * @property string $auto_upgrade 自动升级。1：开启；0：关闭
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcDistribution extends MineModel
{
    protected string $primaryKey = 'id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_distribution';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['site_id', 'type', 'auto_upgrade', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'site_id' => 'integer', 'type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
