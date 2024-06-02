<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\Wxc\Mapper;

use App\Wxc\Model\WxcSharerLevel;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 等级设置Mapper类
 */
class WxcSharerLevelMapper extends AbstractMapper
{
    /**
     * @var WxcSharerLevel
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcSharerLevel::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {

        // 
        if (isset($params['id']) && filled($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        // 租户ID
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 等级ID
        if (isset($params['level_id']) && filled($params['level_id'])) {
            $query->where('level_id', '=', $params['level_id']);
        }

        // 等级名称
        if (isset($params['title']) && filled($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }

        // 一级分销佣金比例，分享员直接销售获得佣金的比例
        if (isset($params['first_tier_rate']) && filled($params['first_tier_rate'])) {
            $query->where('first_tier_rate', '=', $params['first_tier_rate']);
        }

        // 二级分销佣金比例，分享员的下级的客户购买后获得佣金的比例
        if (isset($params['sec_tier_rate']) && filled($params['sec_tier_rate'])) {
            $query->where('sec_tier_rate', '=', $params['sec_tier_rate']);
        }

        // 升级条件
        if (isset($params['upgrade_criteria']) && filled($params['upgrade_criteria'])) {
            $query->where('upgrade_criteria', '=', $params['upgrade_criteria']);
        }

        // 
        if (isset($params['created_at']) && filled($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [$params['created_at'][0], $params['created_at'][1]]
            );
        }

        // 
        if (isset($params['updated_at']) && filled($params['updated_at']) && is_array($params['updated_at']) && count($params['updated_at']) == 2) {
            $query->whereBetween(
                'updated_at',
                [$params['updated_at'][0], $params['updated_at'][1]]
            );
        }

        return $query;
    }

    public function getMaxLevel(): ?WxcSharerLevel
    {
        /** @var ?WxcSharerLevel $res */
        $res = $this->model::orderByDesc('level_id')->first();

        return $res;
    }
}