<?php

declare(strict_types=1);


namespace App\Wxc\Controller\Shop;

use App\Wxc\Mapper\WxcShopCallbackMapper;
use App\Wxc\Service\WxcShopService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 处理消息推送
 */
#[Controller(prefix: "wxc/shop/callback")]
class WxcShopCallbackController extends MineController
{
    #[Inject]
    protected WxcShopCallbackMapper $mapper;

    #[Inject]
    protected WxcShopService $service;

    #[RequestMapping('msgAndEvent')]
    public function index(RequestInterface $request): ResponseInterface
    {
        $this->recordCallbackParam($request);
        return $this->service->serve($request);
    }

    protected function recordCallbackParam($request): void
    {
        $get = $request->getQueryParams();
        $post = $request->getParsedBody();

        $record = [
            'content' => [
                'get' => $get,
                'post' => $post,
            ]
        ];
        $this->mapper->save($record);
    }
}
