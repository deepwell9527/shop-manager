<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Enums\RateMode;
use App\Wxc\Mapper\WxcOrderMapper;
use App\Wxc\Model\WxcOrder;
use App\Wxc\Model\WxcOrderDeliveryInfo;
use App\Wxc\Model\WxcOrderExtInfo;
use App\Wxc\Model\WxcOrderPayInfo;
use App\Wxc\Model\WxcOrderPriceInfo;
use App\Wxc\Model\WxcOrderProductInfo;
use App\Wxc\Model\WxcOrderSharerInfo;
use App\Wxc\Service\Input\GetProductInput;
use App\Wxc\Service\Input\GetSharerInput;
use App\Wxc\Service\Input\SaveOrderDetailInput;
use Deepwell\Concern\QueryService;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use throwable;

/**
 * 订单服务类
 */
class WxcOrderService extends AbstractService
{
    use QueryService;

    /**
     * @var WxcOrderMapper
     */
    public $mapper;
    protected string $queryModelClassName = WxcOrder::class;

    public function __construct(WxcOrderMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function details(mixed $id)
    {
        $order = WxcOrder::with([
            'productInfos',
            'priceInfo',
            'deliveryInfo'
        ])->find($id);

        return $order;
    }

    #[Transaction]
    public function saveOrderDetail(SaveOrderDetailInput $input): void
    {
        $order = $input->order;
        // 保存订单主要信息
        $item = WxcOrder::find($order->order_id);
        $mainInfo = $order->exclude('order_detail', 'aftersale_detail')->toArray();
        $mainInfo['created_at'] = $mainInfo['create_time'];
        $mainInfo['updated_at'] = $mainInfo['update_time'];
        if (!$item) {
            $item = new WxcOrder();
            $item->app_id = $input->app_id;
            $item->order_id = $order->order_id;
        }
        $item->fill($mainInfo)->save();

        $detail = $order->order_detail;

        // 保存订单配送信息
        $deliveryInfo = WxcOrderDeliveryInfo::find($order->order_id);
        if (!$deliveryInfo) {
            $deliveryInfo = new WxcOrderDeliveryInfo();
            $deliveryInfo->app_id = $input->app_id;
            $deliveryInfo->order_id = $order->order_id;
        }
        $deliveryInfo->fill($detail->delivery_info->toArray())->save();

        // 保存订单额外信息
        $extInfo = WxcOrderExtInfo::find($order->order_id);
        if (!$extInfo) {
            $extInfo = new WxcOrderExtInfo();
            $extInfo->app_id = $input->app_id;
            $extInfo->order_id = $order->order_id;
        }
        $extInfo->fill($detail->ext_info->toArray())->save();

        // 保存订单支付信息
        $payInfo = WxcOrderPayInfo::find($order->order_id);
        if (!$payInfo) {
            $payInfo = new WxcOrderPayInfo();
            $payInfo->app_id = $input->app_id;
            $payInfo->order_id = $order->order_id;
        }
        $payInfo->fill($detail->pay_info->toArray())->save();

        // 保存订单价格信息
        $priceInfo = WxcOrderPriceInfo::find($order->order_id);
        if (!$priceInfo) {
            $priceInfo = new WxcOrderPriceInfo();
            $priceInfo->app_id = $input->app_id;
            $priceInfo->order_id = $order->order_id;
        }
        $priceInfo->fill($detail->price_info->toArray())->save();

        // 保存订单商品信息
        foreach ($detail->product_infos as $pItem) {
            $productInfo = WxcOrderProductInfo::where('order_id', $order->order_id)->where('product_id', $pItem->product_id)->where('sku_id', $pItem->sku_id)->first();
            if (!$productInfo) {
                $productInfo = new WxcOrderProductInfo();
                $productInfo->app_id = $input->app_id;
                $productInfo->order_id = $order->order_id;
            }
            $productInfo->fill($pItem->toArray())->save();
        }

        // 保存订单分享员信息
        if (isset($detail->sharer_info)) {
            $sharerInfo = WxcOrderSharerInfo::where('order_id', $order->order_id)->where('sharer_openid', $detail->sharer_info->sharer_openid)->first();
            if (!$sharerInfo) {
                $sharerInfo = new WxcOrderSharerInfo();
                $sharerInfo->app_id = $input->app_id;
                $sharerInfo->order_id = $order->order_id;
            }
            $sharerInfo->fill($detail->sharer_info->toArray())->save();
        }
        if ($detail->sku_sharer_infos->isNotEmpty()) {
            foreach ($detail->sku_sharer_infos as $sItem) {
                $sharerInfo = WxcOrderSharerInfo::where('order_id', $order->order_id)->where('sharer_openid', $sItem->sharer_openid)->where('sku_id', $sItem->sku_id)->first();
                if (!$sharerInfo) {
                    $sharerInfo = new WxcOrderSharerInfo();
                    $sharerInfo->app_id = $input->app_id;
                    $sharerInfo->order_id = $order->order_id;
                }
                $sharerInfo->fill($sItem->toArray())->save();
            }
        }
    }

    /**
     * 确定分享员分佣金额
     * <br>此时分账金额并不会直接入账（分享员佣金账户）
     * @param WxcOrderSharerInfo $item 订单分享员信息
     * @param WxcOrderProductInfo $orderProductInfo 订单商品信息
     * @throws throwable
     */
    public function determineSharerProfit(WxcOrderSharerInfo $item, WxcOrderProductInfo $orderProductInfo): void
    {
        // 分账比例优先级
        // 商品 > 身份等级 > 分享员自身

        // 获取商品佣金信息
        $getProduct = new GetProductInput();
        $getProduct->product_id = $orderProductInfo->product_id;
        $getProduct->with = ['spec'];
        $product = container()->get(WxcProductService::class)->getOne($getProduct);

        // 将分账比例信息缓存
        $rateRules = [];

        // 商品佣金比例
        $productRate = 0;
        if ($product->spec) {
            $rateRules['product'] = [
                'use_commission' => $product->spec->use_commission,
                'commission_rate' => $product->spec->commission_rate,
            ];
            $productRate = $product->spec->commission_rate;
        }

        // 获取分享员信息
        $getSharer = new GetSharerInput();
        $getSharer->openid = $item->sharer_openid;
        $sharer = container()->get(WxcSharerService::class)->getOne($getSharer);
        if ($sharer->spec) {
            // 自定义分佣比例
            $rateRules['sharer'] = [
                'rate_mode' => $sharer->spec->rate_mode,
                'first_tier_rate' => $sharer->spec->first_tier_rate,
                'sec_tier_rate' => $sharer->spec->sec_tier_rate,
            ];
            $customRate = $sharer->spec->first_tier_rate;

            // 身份等级分佣比例
            if ($sharer->spec->levelInfo) {
                $rateRules['sharer']['level_info'] = [
                    'level_id' => $sharer->spec->levelInfo->level_id,
                    'title' => $sharer->spec->levelInfo->title,
                    'first_tier_rate' => $sharer->spec->levelInfo->first_tier_rate,
                    'sec_tier_rate' => $sharer->spec->levelInfo->sec_tier_rate,
                ];
                $levelRate = $sharer->spec->levelInfo->first_tier_rate;
            }
        }
        $rate = match ($sharer->spec->rate_mode) {
            RateMode::Default->value => $productRate ?? $levelRate ?? $customRate ?? 0,
            RateMode::Custom->value => $customRate ?? $productRate ?? $levelRate ?? 0,
            default => 0,
        };

        // 保存当前的各项分佣设置，以便复盘
        $item->rate_rules = $rateRules;

        if ($rate) {
            // 分账金额
            $amount = (int)floor($orderProductInfo->real_price * $rate / 100);
            $item->amount = $amount;
        }

        $item->save();
    }

    public function sync()
    {
        $shopServ = container()->get(WxcShopService::class);
        $shopConfList = $shopServ->getList([
            'select' => 'app_id',
        ]);

        $queueServ = container()->get(WxcQueueService::class);
        $queueServ->setSite(get_current_site());
        foreach ($shopConfList as $conf) {
            $queueServ->syncOrder($conf['app_id']);
        }

        return ['status' => 'promise', 'message' => '同步中'];
    }
}