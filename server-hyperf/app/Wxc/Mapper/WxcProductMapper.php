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

use App\Wxc\Model\WxcProduct;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 商品管理Mapper类
 */
class WxcProductMapper extends AbstractMapper
{
    /**
     * @var WxcProduct
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcProduct::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 商品ID
        if (isset($params['product_id']) && filled($params['product_id'])) {
            $query->where('product_id', '=', $params['product_id']);
        }

        // 
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', '=', $params['app_id']);
        }

        // 标题
        if (isset($params['title']) && filled($params['title'])) {
            $query->where('title', 'like', '%'.$params['title'].'%');
        }

        // 分类
        if (isset($params['cats']) && filled($params['cats'])) {
            $query->where('cats', 'like', '%'.$params['cats'].'%');
        }

        // 主图列表string[]
        if (isset($params['head_imgs']) && filled($params['head_imgs'])) {
            $query->where('head_imgs', '=', $params['head_imgs']);
        }

        // 状态
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        // 草稿状态
        if (isset($params['edit_status']) && filled($params['edit_status'])) {
            $query->where('edit_status', '=', $params['edit_status']);
        }

        // 商品SKU最小价格
        if (isset($params['min_price']) && filled($params['min_price'])) {
            $query->where('min_price', '=', $params['min_price']);
        }

        // 商品SKU最大价格
        if (isset($params['max_price']) && filled($params['max_price'])) {
            $query->where('max_price', '=', $params['max_price']);
        }

        // 最近修改时间
        if (isset($params['edit_time']) && filled($params['edit_time']) && is_array($params['edit_time']) && count($params['edit_time']) == 2) {
            $query->whereBetween(
                'edit_time',
                [ $params['edit_time'][0], $params['edit_time'][1] ]
            );
        }

        $query->with([
            'spec'
        ]);

        return $query;
    }
}