<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Mapper\WxcSharerMapper;
use App\Wxc\Mapper\WxcSharerSpecMapper;
use App\Wxc\Model\WxcSharer;
use App\Wxc\Request\WxcSharerSaveRequest;
use App\Wxc\Service\Input\SharerBindInput;
use Deepwell\ChannelsShop\Api\Sharer\Request\BindRequest;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;

/**
 * 分享员服务类
 */
class WxcSharerService extends AbstractService
{
    use ManageChannelsShopApp;

    /**
     * @var WxcSharerMapper
     */
    public $mapper;

    public function __construct(WxcSharerMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function bind(SharerBindInput $input)
    {
        $client = $this->initApplicationByAppId($input->appId)->sharer;
        $req = BindRequest::from($input);
        return $client->bind($req);
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
            $queueServ->syncSharer($conf['app_id']);
        }

        return ['status' => 'promise', 'message' => '同步中'];
    }

    #[Transaction]
    public function updateSpec(WxcSharerSaveRequest $data): array
    {
        // sharer表存微信端原生字段，一般不做操作
        // sharer_spec表存二次开发所需字段
        $specMapper = container()->get(WxcSharerSpecMapper::class);
        $results = [];
        foreach ($data->sharer_id_list as $sharerId) {
            // 查询sharer
            /** @var WxcSharer $sharer */
            $sharer = $this->mapper->first(['sharer_id' => $sharerId]);
            if (!$sharer) {
                $results[$sharer->sharer_id] = false;
                continue;
            }
            // spec存在则更新，否则新增
            if ($sharer->spec) {
                $res = $specMapper->update($sharer->spec->sharer_id, $data->toArray());
            } else {
                $new = $data->toArray();
                $new['sharer_id'] = $sharer->sharer_id;
                $res = $specMapper->save($new);
            }
            $results[$sharer->sharer_id] = boolval($res);
        }

        return $results;
    }
}