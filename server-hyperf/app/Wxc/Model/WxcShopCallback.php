<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $id
 * @property int $site_id
 * @property int $status
 * @property array $content 请求内容
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WxcShopCallback extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_shop_callback';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'site_id', 'status', 'content', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'site_id' => 'integer', 'status' => 'integer', 'content' => 'array', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
