<?php
declare(strict_types=1);


namespace App\Wxc\Controller\Sharer;

use App\Wxc\Request\WxcSharerLevelSaveRequest;
use App\Wxc\Service\WxcSharerLevelService;
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
 * 等级设置控制器
 */
#[Controller(prefix: "wxc/sharerLevel"), Auth]
#[Middleware(middleware: CheckModuleMiddleware::class)]
class WxcSharerLevelController extends MineController
{
    /**
     * 业务处理服务
     * WxcEcSharerLevelService
     */
    #[Inject]
    protected WxcSharerLevelService $service;


    /**
     * 列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("wxc:sharerLevel, wxc:sharerLevel:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 新增
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("save"), Permission("wxc:sharerLevel:save"), OperationLog]
    public function save(): ResponseInterface
    {
        $request = WxcSharerLevelSaveRequest::validateAndCreate($this->request->all());
        return $this->success(['id' => $this->service->saveLevel($request)]);
    }

    #[PutMapping("update/{id}"), Permission("wxc:sharerLevel:update"), OperationLog]
    public function update(int $id): ResponseInterface
    {
        return $this->service->update($id, $this->request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除数据到回收站
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[DeleteMapping("delete"), Permission("wxc:sharerLevel:delete"), OperationLog]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array)$this->request->input('ids', [])) ? $this->success() : $this->error();
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