<?php

declare(strict_types=1);

namespace App\Wxc\Model;

use Carbon\Carbon;
use Mine\MineModel;

/**
 * @property int $category_id
 * @property string $title 类目名称
 * @property int $pid 父类目ID
 * @property int $level_id 类目等级
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 */
class WxcCategory extends MineModel
{
    protected string $primaryKey = 'category_id';
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wxc_category';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['category_id', 'title', 'pid', 'level_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['category_id' => 'integer', 'pid' => 'integer', 'level_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
