<?php
declare(strict_types=1);

namespace App\OpenWechat\Controller;

use App\OpenWechat\Service\ThirdPartyPlatformService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 授权流程控制器
 */
#[Controller(prefix: "openWechat/authorize")]
class AuthorizeController extends MineController
{
    #[Inject]
    protected ThirdPartyPlatformService $service;


    #[GetMapping("preAuthInfo"), Permission("openWechat:authorizer:save"), Auth]
    public function preAuthInfo(): ResponseInterface
    {
        return $this->success(['preAuthUrl' => $this->service->genPreAuthUrl()]);
    }

    #[PostMapping("callback")]
    public function callback(): ResponseInterface
    {
        $authCode = $this->request->input('auth_code');
        if (empty($authCode)) {
            return $this->error('auth code missing', 422);
        }

        $this->service->saveAuthorizeCallbackInfo($authCode);

        return $this->success();
    }
}