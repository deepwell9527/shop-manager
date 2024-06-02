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

use App\Wxc\Model\WxcOrder;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 订单Mapper类
 */
class WxcOrderMapper extends AbstractMapper
{
    /**
     * @var WxcOrder
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcOrder::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 订单ID
        if (isset($params['order_id']) && filled($params['order_id'])) {
            $query->where('order_id', '=', $params['order_id']);
        }

        // 租户ID
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 视频号小店ID
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', '=', $params['app_id']);
        }

        // 订单状态
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        // 买家身份标识
        if (isset($params['openid']) && filled($params['openid'])) {
            $query->where('openid', '=', $params['openid']);
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

        $query->with([
            'productInfos',
            'priceInfo',
            'deliveryInfo',
            'extInfo'
        ]);

        return $query;
    }
}