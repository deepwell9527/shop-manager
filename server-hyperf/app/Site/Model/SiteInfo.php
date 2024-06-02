<?php

declare(strict_types=1);

namespace App\Site\Model;

use Mine\MineModel;

/**
 * @property int $site_id 租户ID
 * @property string $uuid 站点标识
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 */
class SiteInfo extends MineModel
{
    protected string $primaryKey = 'site_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'site_info';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['site_id', 'uuid', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['site_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

}
