<?php
declare(strict_types=1);

namespace App\Wxc\Mapper;

use App\Wxc\Model\WxcSharerSpec;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 分享员信息Mapper类
 */
class WxcSharerSpecMapper extends AbstractMapper
{
    /**
     * @var WxcSharerSpec
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcSharerSpec::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 主键
        if (isset($params['id']) && filled($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        // 分享员ID
        if (isset($params['sharer_id']) && filled($params['sharer_id'])) {
            $query->where('sharer_id', '=', $params['sharer_id']);
        }

        // 租户ID
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 1：默认（使用商品或等级的分佣比例），2：自定义（使用本表中的比例）
        if (isset($params['rate_mode']) && filled($params['rate_mode'])) {
            $query->where('rate_mode', '=', $params['rate_mode']);
        }

        // 一级分佣比例，0.01~99.99，百分比值
        if (isset($params['first_tier_rate']) && filled($params['first_tier_rate'])) {
            $query->where('first_tier_rate', '=', $params['first_tier_rate']);
        }

        // 二级分佣比例
        if (isset($params['sec_tier_rate']) && filled($params['sec_tier_rate'])) {
            $query->where('sec_tier_rate', '=', $params['sec_tier_rate']);
        }

        // 等级身份ID
        if (isset($params['level_id']) && filled($params['level_id'])) {
            $query->where('level_id', '=', $params['level_id']);
        }

        // 提现手续费，0.01~99.99，百分比值
        if (isset($params['withdrawal_fee']) && filled($params['withdrawal_fee'])) {
            $query->where('withdrawal_fee', '=', $params['withdrawal_fee']);
        }

        // 下单锁客
        if (isset($params['is_order_lock']) && filled($params['is_order_lock'])) {
            $query->where('is_order_lock', '=', $params['is_order_lock']);
        }

        // 锁客失效时间
        if (isset($params['lock_expires_at']) && filled($params['lock_expires_at']) && is_array($params['lock_expires_at']) && count($params['lock_expires_at']) == 2) {
            $query->whereBetween(
                'lock_expires_at',
                [ $params['lock_expires_at'][0], $params['lock_expires_at'][1] ]
            );
        }

        // 自购返佣
        if (isset($params['is_self_buy_back']) && filled($params['is_self_buy_back'])) {
            $query->where('is_self_buy_back', '=', $params['is_self_buy_back']);
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