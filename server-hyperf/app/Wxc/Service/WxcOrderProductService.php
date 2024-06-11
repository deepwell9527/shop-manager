<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Model\WxcOrderProductInfo;
use Deepwell\Concern\QueryService;

/**
 * 订单商品服务类
 */
class WxcOrderProductService
{
    use QueryService;

    protected string $queryModelClassName = WxcOrderProductInfo::class;


    public function __construct()
    {

    }
}