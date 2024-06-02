<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Mapper\WxcAfterSaleMapper;
use Mine\Abstracts\AbstractService;

/**
 * 售后管理服务类
 */
class WxcAfterSaleService extends AbstractService
{
    /**
     * @var WxcAfterSaleMapper
     */
    public $mapper;

    public function __construct(WxcAfterSaleMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}