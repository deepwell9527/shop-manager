<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Mapper\WxcShopInfoMapper;
use App\Wxc\Mapper\WxcShopMapper;
use Deepwell\ChannelsShop\Config;
use Exception;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Stringable\Str;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * 店铺管理服务类
 */
class WxcShopService extends AbstractService
{
    use ManageChannelsShopApp;

    /**
     * @var WxcShopMapper
     */
    public $mapper;

    public function __construct(WxcShopMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function findByAppId(string $appId)
    {
        return $this->mapper->first(['app_id' => $appId]);
    }

    #[Transaction]
    public function update(mixed $id, array $data): bool
    {
        $resp = $this->verifyShop($data);
        $res1 = parent::update($id, $data);
        $info = $resp->info->toArray();
        $info['app_id'] = $data['app_id'];
        $res2 = $this->saveBaseInfo($id, $info);
        return $res1 && $res2;
    }

    public function verifyShop(array $data)
    {
        $config = new Config($data);
        $app = $this->initApplication($config);
        $client = $app->basic;
        try {
            return $client->getBasicInfo();
        } catch (Throwable $e) {
            if (Str::contains($e->getMessage(), 'invalid appid') || Str::contains($e->getMessage(), 'invalid appsecret')) {
                throw new Exception('小店id或小店密钥错误');
            }
            throw $e;
        }
    }

    public function saveBaseInfo(int $shopId, array $info)
    {
        $infoMapper = container()->get(WxcShopInfoMapper::class);
        $baseInfo = $infoMapper->first(['shop_id' => $shopId]);
        if (!$baseInfo) {
            $info['shop_id'] = $shopId;
            $shopId = $infoMapper->save($info);
            return boolval($shopId);
        } else {
            return $infoMapper->update($baseInfo->shop_id, $info);
        }
    }

    /**
     * @throws Throwable
     */
    #[Transaction]
    public function save(array $data): mixed
    {
        $resp = $this->verifyShop($data);
        $shopId = parent::save($data);
        $info = $resp->info->toArray();
        $info['app_id'] = $data['app_id'];
        $this->saveBaseInfo($shopId, $info);
        return $shopId;
    }

    /**
     * 处理小店消息回调
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function serve(RequestInterface $request): ResponseInterface
    {
        // 根据appid获取小店配置
        $appId = $request->query('app_id');
        $data = $this->mapper->getShopByAppId($appId);
        if (!$data) {
            throw new Exception('小店不存在：' . $appId);
        }
        $config = new Config($data->toArray());
        $app = $this->initApplication($config);
        $app->setRequest($request);
        $server = $app->getServer();
        return $server->serve();
    }
}