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

use App\Wxc\Model\WxcDistribution;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 分销设置Mapper类
 */
class WxcDistributionMapper extends AbstractMapper
{
    /**
     * @var WxcDistribution
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcDistribution::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 租户Id
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 分销模式。1：一级；2：二级；3：多级
        if (isset($params['type']) && filled($params['type'])) {
            $query->where('type', '=', $params['type']);
        }

        // 自动升级。1：开启；0：关闭
        if (isset($params['auto_upgrade']) && filled($params['auto_upgrade'])) {
            $query->where('auto_upgrade', '=', $params['auto_upgrade']);
        }

        // 等级设置
        if (isset($params['level_info']) && filled($params['level_info'])) {
            $query->where('level_info', '=', $params['level_info']);
        }

        // 
        if (isset($params['created_at']) && filled($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0], $params['created_at'][1] ]
            );
        }

        // 
        if (isset($params['updated_at']) && filled($params['updated_at']) && is_array($params['updated_at']) && count($params['updated_at']) == 2) {
            $query->whereBetween(
                'updated_at',
                [ $params['updated_at'][0], $params['updated_at'][1] ]
            );
        }

        return $query;
    }
}