<?php
declare(strict_types=1);

namespace HyperfTests\Cases;

use App\OpenWechat\Mapper\CallbackRecordMapper;
use App\OpenWechat\Service\ThirdPartyPlatformService;
use Hyperf\Context\RequestContext;
use Hyperf\Engine\Http\Stream;
use Hyperf\HttpMessage\Server\Request;
use HyperfTests\HttpTestCase;

class OpenWechatCallbackTest extends HttpTestCase
{
    public function testOpenWechatThirdPartyPlatformCallback()
    {
        $record = container()->get(CallbackRecordMapper::class)->read(115);
        $service = container()->get(ThirdPartyPlatformService::class);
        $request = new Request(
            'POST',
            '/openWechat/callback/thirdPartyPlatform/authEvent',);
        $request = $request->withQueryParams($record->content['get'])->withBody(new Stream($record->content['xml']))->withParsedBody($record->content['post']);
        RequestContext::set($request);

        $r = new \Hyperf\HttpServer\Request();
        $response = $service->serve($r);
        dump($response);

        $this->assertTrue(!empty($record));
    }
}