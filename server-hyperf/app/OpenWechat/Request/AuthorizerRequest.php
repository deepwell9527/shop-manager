<?php
declare(strict_types=1);

namespace App\OpenWechat\Request;

use Mine\MineFormRequest;

/**
 * 授权信息验证数据类
 */
class AuthorizerRequest extends MineFormRequest
{
    /**
     * 公共规则
     */
    public function commonRules(): array
    {
        return [];
    }


    /**
     * 新增数据验证规则
     * return array
     */
    public function saveRules(): array
    {
        return [
            //授权方appid 验证
            'app_id' => 'required',
            //授权码 验证
            'code' => 'required',
            //授权码过期时间 验证
            'code_expired_time' => 'required',

        ];
    }

    /**
     * 更新数据验证规则
     * return array
     */
    public function updateRules(): array
    {
        return [
            //授权方appid 验证
            'app_id' => 'required',
            //授权码 验证
            'code' => 'required',
            //授权码过期时间 验证
            'code_expired_time' => 'required',

        ];
    }


    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'app_id' => '授权方appid',
            'code' => '授权码',
            'code_expired_time' => '授权码过期时间',

        ];
    }

}