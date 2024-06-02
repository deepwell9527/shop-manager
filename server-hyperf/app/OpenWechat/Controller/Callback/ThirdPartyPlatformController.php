<?php

declare(strict_types=1);


namespace App\OpenWechat\Controller\Callback;

use App\OpenWechat\Mapper\CallbackRecordMapper;
use App\OpenWechat\Service\ThirdPartyPlatformService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 定时任务控制器
 * Class CrontabController.
 */
#[Controller(prefix: 'openWechat/callback/thirdPartyPlatform')]
class ThirdPartyPlatformController extends MineController
{
    #[Inject]
    protected ThirdPartyPlatformService $thirdPartyPlatformService;

    #[Inject]
    protected CallbackRecordMapper $callbackRecordMapper;

    #[PostMapping('authEvent')]
    public function authEvent(RequestInterface $request): string
    {
        $this->recordCallbackParam($request);

        $this->thirdPartyPlatformService->serve($request);

        return 'success';
    }

    protected function recordCallbackParam($request): void
    {
        $get = $request->getQueryParams();
        $post = $request->getParsedBody();
        $cookie = $request->getCookieParams();
        $server = $request->getServerParams();
        $xml = $request->getBody()->getContents();

        $record = [
            'content' => [
                'get' => $get,
                'post' => $post,
                'cookie' => $cookie,
                'server' => $server,
                'xml' => $xml,
            ]
        ];
        $this->callbackRecordMapper->save($record);
    }

    #[PostMapping('msgAndEvent')]
    public function msgAndEvent(RequestInterface $request): ResponseInterface
    {
        $this->recordCallbackParam($request);

        return $this->thirdPartyPlatformService->serve($request);
    }
}
