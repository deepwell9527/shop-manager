<?php
declare(strict_types=1);

namespace App\Wxc\Controller\AfterSale;

use App\Wxc\Service\WxcAfterSaleService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\Annotation\RemoteState;
use Mine\Middlewares\CheckModuleMiddleware;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 售后管理控制器
 * Class WxcAfterSaleController
 */
#[Controller(prefix: "wxc/afterSale"), Auth]
#[Middleware(middleware: CheckModuleMiddleware::class)]
class WxcAfterSaleController extends MineController
{
    /**
     * 业务处理服务
     * WxcAfterSaleService
     */
    #[Inject]
    protected WxcAfterSaleService $service;


    /**
     * 列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("wxc:afterSale, wxc:afterSale:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 读取数据
     * @param int $id
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("read/{id}"), Permission("wxc:afterSale:read")]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
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