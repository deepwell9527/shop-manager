<?php
declare(strict_types=1);

namespace App\Wxc\Mapper;

use App\Wxc\Model\WxcSharer;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 分享员Mapper类
 */
class WxcSharerMapper extends AbstractMapper
{
    /**
     * @var WxcSharer
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcSharer::class;
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

        // 
        if (isset($params['site_id']) && filled($params['site_id'])) {
            $query->where('site_id', '=', $params['site_id']);
        }

        // 
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', '=', $params['app_id']);
        }

        // openid
        if (isset($params['openid']) && filled($params['openid'])) {
            $query->where('openid', '=', $params['openid']);
        }

        // 分享员昵称
        if (isset($params['nickname']) && filled($params['nickname'])) {
            $query->where('nickname', '=', $params['nickname']);
        }

        // 绑定时间
        if (isset($params['bind_time']) && filled($params['bind_time']) && is_array($params['bind_time']) && count($params['bind_time']) == 2) {
            $query->whereBetween(
                'bind_time',
                [$params['bind_time'][0], $params['bind_time'][1]]
            );
        }

        // 分享员类型
        if (isset($params['sharer_type']) && filled($params['sharer_type'])) {
            $query->where('sharer_type', '=', $params['sharer_type']);
        }

        // unionid
        if (isset($params['unionid']) && filled($params['unionid'])) {
            $query->where('unionid', '=', $params['unionid']);
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

        // parent_sharer_id
        if (!empty($params['parent_sharer_id'])) {
            $query->whereExists(function ($query) use ($params) {
                $query->select('sharer_id')
                    ->from('wxc_sharer_spec')
                    ->whereRaw('sharer_id = wxc_sharer.sharer_id')
                    ->where('parent_sharer_id', $params['parent_sharer_id']);
            });
        }

        $query->with(['spec', 'parent']);

        return $query;
    }
}