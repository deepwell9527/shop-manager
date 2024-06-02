<?php
declare(strict_types=1);

namespace App\Wxc\Controller\Distribution;

use App\Wxc\Request\WxcDistributionSaveRequest;
use App\Wxc\Service\WxcDistributionService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\Annotation\RemoteState;
use Mine\Middlewares\CheckModuleMiddleware;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 分销设置控制器
 * Class WxcEcDistributionController
 */
#[Controller(prefix: "wxc/ecDistribution"), Auth]
#[Middleware(middleware: CheckModuleMiddleware::class)]
class WxcDistributionController extends MineController
{
    /**
     * 业务处理服务
     * WxcEcDistributionService
     */
    #[Inject]
    protected WxcDistributionService $service;


    /**
     * 列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("wxc:ecDistribution, wxc:ecDistribution:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    #[PutMapping("update"), Permission("wxc:ecDistribution:update"), OperationLog]
    public function update(): ResponseInterface
    {
        $request = WxcDistributionSaveRequest::validateAndCreate($this->request->all());
        return $this->service->saveSettings($request) ? $this->success() : $this->error();
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
}