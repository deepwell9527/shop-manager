<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Mapper\WxcProductMapper;
use App\Wxc\Model\WxcProduct;
use App\Wxc\Model\WxcProductSpec;
use App\Wxc\Request\WxcProductSaveRequest;
use Deepwell\Concern\QueryService;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;

/**
 * 商品管理服务类
 */
class WxcProductService extends AbstractService
{
    use ManageChannelsShopApp;
    use QueryService;

    /**
     * @var WxcProductMapper
     */
    public $mapper;

    protected string $queryModelClassName = WxcProduct::class;

    public function __construct(WxcProductMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function sync()
    {
        $shopServ = container()->get(WxcShopService::class);
        $shopConfList = $shopServ->getList([
            'select' => 'app_id',
        ]);

        $queueServ = container()->get(WxcQueueService::class);

        foreach ($shopConfList as $conf) {
            $queueServ->syncProduct($conf['app_id']);
        }

        return ['status' => 'promise', 'message' => '同步中'];
//        $app = $this->initApplicationByAppId($appId);
//        $client = $app->getClient();
//        $response = $client->get('/channels/ec/product/list/get');
    }

    #[Transaction]
    public function updateSpec(WxcProductSaveRequest $data): array
    {
        // product表存微信端原生字段，一般不做操作
        // product_spec表存二次开发所需字段
        $results = [];
        foreach ($data->product_id_list as $productId) {
            /** @var WxcProduct $p */
            $p = WxcProduct::find($productId);
            if (!$p) {
                $results[$productId] = false;
                continue;
            }
            // spec存在则更新，否则新增
            $spec = $p->spec;
            if (!$spec) {
                $spec = new WxcProductSpec();
                $spec->product_id = $productId;
                $spec->app_id = $p->app_id;
            }
            $spec->use_commission = $data->use_commission;
            $spec->commission_rate = $data->commission_rate;
            $results[$productId] = $spec->save();
        }

        return $results;
    }
}