<?php
declare(strict_types=1);

namespace App\OpenWechat\Mapper;

use App\OpenWechat\Model\Authorizer;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 授权信息Mapper类
 */
class AuthorizerMapper extends AbstractMapper
{
    /**
     * @var Authorizer
     */
    public $model;

    public function assignModel()
    {
        $this->model = Authorizer::class;
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

        // 授权方appid
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', 'like', '%' . $params['app_id'] . '%');
        }

        // 授权码
        if (isset($params['code']) && filled($params['code'])) {
            $query->where('code', 'like', '%' . $params['code'] . '%');
        }

        // 授权码过期时间
        if (isset($params['code_expired_time']) && filled($params['code_expired_time']) && is_array($params['code_expired_time']) && count($params['code_expired_time']) == 2) {
            $query->whereBetween(
                'code_expired_time',
                [$params['code_expired_time'][0], $params['code_expired_time'][1]]
            );
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

    public function save(array $data): mixed
    {
        $exist = $this->first([
            //'site_id'=>$data['site_id'],
            'app_id'=>$data['app_id'],
        ]);
        if($exist){
            if($exist->site_id!=$data['site_id']){
                return $exist->{$exist->getKeyName()};
            }
            return $exist->{$exist->getKeyName()};
        }
        return parent::save($data);
    }
}