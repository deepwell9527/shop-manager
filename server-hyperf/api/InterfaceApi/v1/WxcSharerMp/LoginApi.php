<?php

declare(strict_types=1);


namespace Api\InterfaceApi\V1\WxcSharerMp;

use Api\Request\V1\UserInfoRequest;
use App\System\Mapper\SystemDeptMapper;
use App\System\Mapper\SystemUserMapper;
use Mine\Annotation\Api\MApi;
use Mine\Annotation\Api\MApiRequestParam;
use Mine\Annotation\Api\MApiResponseParam;
use Mine\MineResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 登录接口
 */
class LoginApi
{
    protected SystemUserMapper $user;

    protected SystemDeptMapper $dept;

    protected MineResponse $response;

    /**
     * DemoApi constructor.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(SystemUserMapper $user, SystemDeptMapper $dept)
    {
        $this->response = container()->get(MineResponse::class);
        $this->user = $user;
        $this->dept = $dept;
    }

    /**
     * 登录
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    // appId 换成自己的 groupId 换成自己的 (前端更新，这两个必须有，后台才能看到文档
    #[MApi(accessName: 'sharerMp.login', name: '登录', description: '登录', appId: '3df749ab62', authMode: 100, groupId: 3)]
    public function login(): ResponseInterface
    {
        // 第二个参数，不进行数据权限检查，否则会拉起检测是否登录。
        return $this->response->success('请求成功', $this->user->getPageList([], false));
    }
}
