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
namespace App\Wxc\Request;

use Mine\MineFormRequest;

/**
 * 店铺管理验证数据类
 */
class WxcShopRequest extends MineFormRequest
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
            //小店id 验证
            'app_id' => 'required',
            //小店密钥 验证
            'secret' => 'required',
            //消息校验令牌 验证
            'token' => 'required',
            //消息密钥 验证
            'aes_key' => 'required',

        ];
    }
    /**
     * 更新数据验证规则
     * return array
     */
    public function updateRules(): array
    {
        return [
            //小店id 验证
            'app_id' => 'required',
            //小店密钥 验证
            'secret' => 'required',

        ];
    }

    
    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'app_id' => '小店id',
            'secret' => '小店密钥',
            'token' => '消息校验令牌',
            'aes_key' => '消息密钥',

        ];
    }

}