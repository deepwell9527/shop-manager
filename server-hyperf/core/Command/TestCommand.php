<?php

declare(strict_types=1);

namespace Deepwell\Command;

use App\Wxc\Enums\RateMode;
use App\Wxc\Model\WxcOrderSharerInfo;
use App\Wxc\Service\Input\GetOrderProductInput;
use App\Wxc\Service\Input\GetProductInput;
use App\Wxc\Service\Input\GetSharerInput;
use App\Wxc\Service\WxcOrderProductService;
use App\Wxc\Service\WxcOrderService;
use App\Wxc\Service\WxcProductService;
use App\Wxc\Service\WxcSharerService;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;

#[Command]
class TestCommand extends HyperfCommand
{
    protected ?string $name = 'app:test';

    public function handle()
    {
        WxcOrderSharerInfo::where('status', 0)->whereExists(function ($query) {
            $query->from('wxc_order as t1')->whereRaw('t1.order_id = wxc_order_sharer_info.order_id')->where('t1.status', 100);
        })->chunk(100, function ($items) {
            /** @var WxcOrderSharerInfo $item */
            foreach ($items as $item) {
                // 获取订单商品信息
                $getOrderProduct = new GetOrderProductInput();
                $getOrderProduct->order_id = $item->order_id;
                $getOrderProduct->sku_id = $item->sku_id;
                $orderProductInfo = container()->get(WxcOrderProductService::class)->getOne($getOrderProduct);

                container()->get(WxcOrderService::class)->determineSharerProfit($item,$orderProductInfo);
            }
        });
    }
}