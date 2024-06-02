<?php
declare (strict_types=1);

namespace App\OpenWechat\Model;

use Mine\MineModel;

class Authorizer extends MineModel
{
    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected ?string $table = 'open_wechat_authorizer';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [
        'id', 'site_id', 'app_id', 'access_token', 'refresh_token', 'expire_at','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = [
        'code_expired_time' => 'datetime'
    ];


}