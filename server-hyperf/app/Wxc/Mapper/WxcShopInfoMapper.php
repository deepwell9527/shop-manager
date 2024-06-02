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

use App\Wxc\Model\WxcShopInfo;
use Mine\Abstracts\AbstractMapper;

/**
 * 店铺管理Mapper类
 */
class WxcShopInfoMapper extends AbstractMapper
{
    /**
     * @var WxcShopInfo
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcShopInfo::class;
    }
}