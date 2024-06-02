<?php

declare(strict_types=1);

namespace App\OpenWechat\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $id
 * @property array $content 请求内容
 * @property Carbon $created_at
 */
class CallbackRecord extends MineModel
{
    const UPDATED_AT = null;
    public bool $timestamps = true;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'open_wechat_callback_record';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'content', 'created_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'content' => 'array'];
}
