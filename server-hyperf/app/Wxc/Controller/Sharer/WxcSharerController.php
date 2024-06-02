<?php
declare(strict_types=1);

namespace App\Wxc\Controller\Sharer;

use App\Wxc\Request\WxcSharerSaveRequest;
use App\Wxc\Service\Input\SharerBindInput;
use App\Wxc\Service\WxcSharerService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\Annotation\RemoteState;
use Mine\Middlewares\CheckModuleMiddleware;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 分享员控制器
 * Class WxcEcSharerController
 */
#[Controller(prefix: "wxc/sharer"), Auth]
#[Middleware(middleware: CheckModuleMiddleware::class)]
class WxcSharerController extends MineController
{
    /**
     * 业务处理服务
     * WxcEcSharerService
     */
    #[Inject]
    protected WxcSharerService $service;


    /**
     * 列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("wxc:sharer, wxc:sharer:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }


    /**
     * 远程万能通用列表接口
     * @return ResponseInterface
     */
    #[PostMapping("remote"), RemoteState(true)]
    public function remote(): ResponseInterface
    {
        return $this->success($this->service->getRemoteList($this->request->all()));
    }

    /**
     * 获取邀请二维码
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("bind"), Permission("wxc:sharer, wxc:sharer:bind")]
    public function bind(): ResponseInterface
    {
        $req = SharerBindInput::from($this->request);
        return $this->success($this->service->bind($req));
    }

    #[PostMapping("sync"), Permission("wxc:sharer, wxc:sharer:sync")]
    public function sync(): ResponseInterface
    {
        return $this->success($this->service->sync());
    }

    #[PutMapping("update/spec"), Permission("wxc:sharer, wxc:sharer:update")]
    public function updateSpec(): ResponseInterface
    {
        $req = WxcSharerSaveRequest::validateAndCreate($this->request->all());
        return $this->success($this->service->updateSpec($req));
    }
}