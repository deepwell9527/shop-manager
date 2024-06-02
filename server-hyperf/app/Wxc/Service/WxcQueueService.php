<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Site\Dto\SiteInfoDto;
use App\Site\Service\SiteInfoService;
use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Mapper\WxcProductMapper;
use App\Wxc\Mapper\WxcSharerMapper;
use App\Wxc\Service\Input\SaveOrderDetailInput;
use Carbon\Carbon;
use Deepwell\ChannelsShop\Api\Order\Request\GetOrderDetailRequest;
use Deepwell\ChannelsShop\Api\Order\Request\GetOrderListRequest;
use Deepwell\ChannelsShop\Api\Product\Enums\SkuStatus;
use Deepwell\ChannelsShop\Api\Product\Request\GetProductDetailRequest;
use Deepwell\ChannelsShop\Api\Product\Request\GetProductListRequest;
use Deepwell\ChannelsShop\Api\Sharer\Enums\SharerType;
use Deepwell\ChannelsShop\Api\Sharer\Request\GetSharerListRequest;
use Exception;
use Hyperf\DbConnection\Db;
use Throwable;

class WxcQueueService
{
    use ManageChannelsShopApp;

    public function setSite(int|SiteInfoDto $site): void
    {
        if (is_a($site, SiteInfoDto::class)) {
            set_current_site($site);
        } else {
            $site = container()->get(SiteInfoService::class)->findBySiteId($site);
            if (!$site) {
                throw new Exception('site id invalid');
            }
            set_current_site(SiteInfoDto::from($site));
        }
    }

    /**
     * 同步微信视频号小店商品
     * @param $appId
     * @return void
     * @throws Throwable
     */
    //#[AsyncQueueMessage('wxc_ec_product', 5)]
    public function syncProduct($appId)
    {
        $app = $this->initApplicationByAppId($appId);
        $client = $app->product;
        $nextKey = '';
        $datalist = [];
        while (true) {
            $req1 = GetProductListRequest::from([
                'next_key' => $nextKey,
                'status' => SkuStatus::OnSale,
            ]);
            $resp1 = $client->getList($req1);
            $pIds = $resp1->product_ids;
            if (empty($pIds)) {
                break;
            }
            $nextKey = $resp1->next_key;

            foreach ($pIds as $id) {
                $req2 = GetProductDetailRequest::from([
                    'product_id' => $id,
                    'data_type' => 1,
                ]);
                $resp2 = $client->getDetail($req2);
                $productInfo = $resp2->product;
                $cats = '';
                if ($productInfo->cats->isNotEmpty()) {
                    $cats = implode(',', $productInfo->cats->pluck('cat_id')->toArray());
                }
                // 根据skus信息，计算出商品最大价格
                //$priceList = array_column($productInfo->skus, 'sale_price')
                //$maxPrice = max($priceList);
                $maxPrice = $productInfo->skus->max('sale_price');
                $datalist[] = [
                    'app_id' => $appId,
                    'product_id' => $id,
                    'title' => $productInfo->title,
                    'cats' => $cats,
                    'head_imgs' => [$productInfo->head_imgs[0]],
                    'status' => $productInfo->status,
                    //'edit_status' => $productInfo->edit_status,
                    'min_price' => $productInfo->min_price,
                    'max_price' => $maxPrice,
                    //'edit_time' => $productInfo->edit_time,
                ];
            }
        }
        Db::transaction(function () use ($datalist) {
            $syncedAt = time();
            $ecProductMapper = container()->get(WxcProductMapper::class);
            foreach ($datalist as $item) {
                $item['synced_at'] = $syncedAt;
                $exist = $ecProductMapper->first(['product_id' => $item['product_id']]);
                if ($exist) {
                    $ecProductMapper->update($exist->product_id, $item);
                } else {
                    $ecProductMapper->save($item);
                }
            }
        });
    }

    public function syncSharer($appId)
    {
        $app = $this->initApplicationByAppId($appId);
        $client = $app->sharer;

        // 普通分享员
        $page = 1;
        while (true) {
            $req = new GetSharerListRequest($page, 100, SharerType::Normal);
            $resp = $client->getList($req);
            if (!empty($resp->sharerInfoList)) {
                $this->saveSharer($appId, $resp->sharerInfoList);
                $page++;
            } else {
                break;
            }
        }

        // 店铺分享员
        $page = 1;
        while (true) {
            $req = new GetSharerListRequest($page, 100, SharerType::Shop);
            $resp = $client->getList($req);
            if (!empty($resp->sharerInfoList)) {
                $this->saveSharer($appId, $resp->sharerInfoList);
                $page++;
            } else {
                break;
            }
        }
    }

    protected function saveSharer($appId, $sharerInfoList)
    {
        $ecSharerMapper = container()->get(WxcSharerMapper::class);
        $syncedAt = time();
        $datalist = [];
        foreach ($sharerInfoList as $item) {
            $datalist[] = [
                'app_id' => $appId,
                'openid' => $item->openid,
                'unionid' => $item->unionid,
                'sharer_type' => $item->sharerType->value,
                'bind_time' => $item->bindTime,
                'nickname' => $item->nickname,
                'synced_at' => $syncedAt,
            ];
        }
        Db::transaction(function () use ($datalist, $ecSharerMapper) {
            foreach ($datalist as $item) {
                $exist = $ecSharerMapper->first([
                    'app_id' => $item['app_id'],
                    'openid' => $item['openid'],
                ]);
                if ($exist) {
                    $ecSharerMapper->update($exist->app_id, $item);
                } else {
                    $ecSharerMapper->save($item);
                }
            }
        });
    }

    /**
     * 同步微信视频号小店商品
     * @param string $appId
     * @return void
     * @throws Throwable
     */
    //#[AsyncQueueMessage('wxc_ec_product', 5)]
    public function syncOrder(string $appId)
    {
        $orderService = container()->get(WxcOrderService::class);
        $app = $this->initApplicationByAppId($appId);
        $client = $app->order;
        $nextKey = '';
        $endTime = Carbon::now()->subDays(5);
        $startTime = $endTime->copy()->subDays(7);
        while (true) {
            // 获取订单列表，列表仅有简单的信息
            $req = GetOrderListRequest::from([
                'next_key' => $nextKey,
                'page_size' => 10,
                'create_time_range' => [
                    'start_time' => $startTime->timestamp,
                    'end_time' => $endTime->timestamp,
                ],
            ]);
            $resp = $client->getList($req);
            if ($resp->errcode !== 0) {
                throw new Exception($resp->errmsg);
            }

            $nextKey = $resp->next_key;

            // 通过订单id获取订单详情
            foreach ($resp->order_id_list as $orderId) {
                $reqDetail = new GetOrderDetailRequest();
                $reqDetail->order_id = $orderId;
                $respDetail = $client->getDetail($reqDetail);
                $input = SaveOrderDetailInput::from([
                    'app_id' => $appId,
                    'order' => $respDetail->order,
                ]);
                $orderService->saveOrderDetail($input);
            }

            if (!$resp->has_more) {
                break;
            }

        }
    }
}