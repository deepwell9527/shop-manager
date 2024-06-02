<?php
declare(strict_types=1);

namespace App\Wxc\Controller\Product;

use App\Wxc\Request\WxcProductSaveRequest;
use App\Wxc\Service\WxcProductService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
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
 * 商品管理控制器
 */
#[Controller(prefix: "wxc/product"), Auth]
#[Middleware(middleware: CheckModuleMiddleware::class)]
class WxcProductController extends MineController
{
    /**
     * 业务处理服务
     * WxcEcProductService
     */
    #[Inject]
    protected WxcProductService $service;


    /**
     * 列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("wxc:product, wxc:product:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 单个或批量删除数据到回收站
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[DeleteMapping("delete"), Permission("wxc:product:delete"), OperationLog]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array)$this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 更改数据状态
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PutMapping("changeStatus"), Permission("wxc:product:update"), OperationLog]
    public function changeStatus(): ResponseInterface
    {
        return $this->service->changeStatus(
            (int)$this->request->input('setting_generate_tables.id'),
            (string)$this->request->input('statusValue'),
            (string)$this->request->input('statusName', 'status')
        ) ? $this->success() : $this->error();
    }


    /**
     * 远程万能通用列表接口
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("remote"), RemoteState(true)]
    public function remote(): ResponseInterface
    {
        return $this->success($this->service->getRemoteList($this->request->all()));
    }

    /**
     * 同步商品
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("sync"), Permission("wxc:product, wxc:product:sync")]
    public function sync(): ResponseInterface
    {
        return $this->success($this->service->sync());
    }

    #[PutMapping("update/spec"), Permission("wxc:product, wxc:product:update")]
    public function updateSpec(): ResponseInterface
    {
        $req = WxcProductSaveRequest::validateAndCreate($this->request->all());
        return $this->success($this->service->updateSpec($req));
    }
}