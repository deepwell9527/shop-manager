<?php
declare(strict_types=1);


namespace App\Wxc\Mapper;

use App\Wxc\Model\WxcShopCallback;
use Mine\Abstracts\AbstractMapper;


class WxcShopCallbackMapper extends AbstractMapper
{
    /**
     * @var WxcShopCallback
     */
    public $model;

    public function assignModel()
    {
        $this->model = WxcShopCallback::class;
    }
}