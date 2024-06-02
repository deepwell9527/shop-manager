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

use App\Wxc\Model\WxcAfterSale;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 售后管理Mapper类
 */
class WxcAfterSaleMapper extends AbstractMapper
{
    /**
     * @var WxcAfterSale
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcAfterSale::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 售后单号
        if (isset($params['after_sale_order_id']) && filled($params['after_sale_order_id'])) {
            $query->where('after_sale_order_id', '=', $params['after_sale_order_id']);
        }

        // 租户ID
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 视频号小店ID
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', '=', $params['app_id']);
        }

        // 售后单当前状态
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', 'like', '%'.$params['status'].'%');
        }

        // 买家身份标识
        if (isset($params['openid']) && filled($params['openid'])) {
            $query->where('openid', '=', $params['openid']);
        }

        // 买家在开放平台的唯一标识符
        if (isset($params['unionid']) && filled($params['unionid'])) {
            $query->where('unionid', '=', $params['unionid']);
        }

        // 售后相关商品信息
        if (isset($params['product_info']) && filled($params['product_info'])) {
            $query->where('product_info', '=', $params['product_info']);
        }

        // 售后详情
        if (isset($params['details']) && filled($params['details'])) {
            $query->where('details', '=', $params['details']);
        }

        // 退款详情
        if (isset($params['refund_info']) && filled($params['refund_info'])) {
            $query->where('refund_info', '=', $params['refund_info']);
        }

        // 用户退货信息
        if (isset($params['return_info']) && filled($params['return_info'])) {
            $query->where('return_info', '=', $params['return_info']);
        }

        // 商家上传的信息
        if (isset($params['merchant_upload_info']) && filled($params['merchant_upload_info'])) {
            $query->where('merchant_upload_info', '=', $params['merchant_upload_info']);
        }

        // 退款原因
        if (isset($params['reason']) && filled($params['reason'])) {
            $query->where('reason', 'like', '%'.$params['reason'].'%');
        }

        // 退款原因解释
        if (isset($params['reason_text']) && filled($params['reason_text'])) {
            $query->where('reason_text', 'like', '%'.$params['reason_text'].'%');
        }

        // 售后类型
        if (isset($params['type']) && filled($params['type'])) {
            $query->where('type', 'like', '%'.$params['type'].'%');
        }

        // 纠纷id
        if (isset($params['complaint_id']) && filled($params['complaint_id'])) {
            $query->where('complaint_id', '=', $params['complaint_id']);
        }

        // 订单号
        if (isset($params['order_id']) && filled($params['order_id'])) {
            $query->where('order_id', '=', $params['order_id']);
        }

        // 微信支付退款的响应
        if (isset($params['refund_resp']) && filled($params['refund_resp'])) {
            $query->where('refund_resp', '=', $params['refund_resp']);
        }

        // 操作剩余时间（秒数）
        if (isset($params['deadline']) && filled($params['deadline'])) {
            $query->where('deadline', '=', $params['deadline']);
        }

        // 售后单创建时间戳
        if (isset($params['created_at']) && filled($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0], $params['created_at'][1] ]
            );
        }

        // 售后单更新时间戳
        if (isset($params['updated_at']) && filled($params['updated_at']) && is_array($params['updated_at']) && count($params['updated_at']) == 2) {
            $query->whereBetween(
                'updated_at',
                [ $params['updated_at'][0], $params['updated_at'][1] ]
            );
        }

        return $query;
    }
}