<?php
declare(strict_types=1);

namespace HyperfTests\Cases;

use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Service\WxcQueueService;
use Deepwell\ChannelsShop\Api\Sharer\Enums\SharerType;
use Deepwell\ChannelsShop\Api\Sharer\Request\BindRequest;
use Deepwell\ChannelsShop\Api\Sharer\Request\GetSharerListRequest;
use PHPUnit\Framework\TestCase;

class WxcEcSharerTest extends TestCase
{
    use ManageChannelsShopApp;

    public function testWxcEcSharerBind()
    {
        $app = $this->initApplicationByAppId('wx028b072b6afd5694');

        $client = $app->ecSharer();
        $req = BindRequest::from([]);
        $resp = $client->bind($req);
        dump($resp->toArray());
        $this->assertNotEmpty($resp->toArray());
    }

    public function testWxcEcSharerList()
    {
        $app = $this->initApplicationByAppId('wx028b072b6afd5694');

        $client = $app->ecSharer();
        $req = new GetSharerListRequest(1, 100, SharerType::Normal);
        $resp = $client->getSharerList($req);
        dump($resp->toArray());
        $this->assertNotEmpty($resp->toArray());
    }

    public function testWxcEcSharerSync()
    {
        $serv = container()->get(WxcQueueService::class);
        $serv->setSite(1000);
        $serv->syncSharer('wx028b072b6afd5694');
        //dump($resp->toArray());
        $this->assertTrue(true);
    }
}