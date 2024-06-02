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

use App\Wxc\Model\WxcShop;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 店铺管理Mapper类
 */
class WxcShopMapper extends AbstractMapper
{
    /**
     * @var WxcShop
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcShop::class;
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
        if (isset($params['shop_id']) && filled($params['shop_id'])) {
            $query->where('shop_id', '=', $params['shop_id']);
        }

        // 小店id
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', 'like', '%'.$params['app_id'].'%');
        }

        // 小店密钥
        if (isset($params['secret']) && filled($params['secret'])) {
            $query->where('secret', 'like', '%'.$params['secret'].'%');
        }

        // 消息校验令牌
        if (isset($params['token']) && filled($params['token'])) {
            $query->where('token', 'like', '%'.$params['token'].'%');
        }

        // 消息密钥
        if (isset($params['aes_key']) && filled($params['aes_key'])) {
            $query->where('aes_key', 'like', '%'.$params['aes_key'].'%');
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

    public function getShopByAppId(string $appId)
    {
        return $this->first(['app_id' => $appId]);
    }
}