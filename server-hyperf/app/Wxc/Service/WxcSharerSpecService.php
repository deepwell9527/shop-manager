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

namespace App\Wxc\Service;

use App\Wxc\Mapper\WxcSharerSpecMapper;
use Mine\Abstracts\AbstractService;

/**
 * 分享员信息服务类
 */
class WxcSharerSpecService extends AbstractService
{
    /**
     * @var WxcSharerSpecMapper
     */
    public $mapper;

    public function __construct(WxcSharerSpecMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}