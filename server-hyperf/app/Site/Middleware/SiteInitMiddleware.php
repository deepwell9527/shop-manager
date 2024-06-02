<?php

declare(strict_types=1);

namespace App\Site\Middleware;

use App\Site\Dto\SiteInfoDto;
use App\Site\Service\SiteInfoService;
use Exception;
use Hyperf\HttpMessage\Server\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class SiteInitMiddleware implements MiddlewareInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->ignore($request)) {
            return $handler->handle($request);
        }

        /** @var Request $request */
        $uuid = $request->getHeader('uuid')[0] ?? $request->getQueryParams()['uuid'] ?? null;
        if (empty($uuid)) {
            throw new Exception('uuid missing');
        }
        $siteInfo = container()->get(SiteInfoService::class)->findByUuid($uuid);
        if (!$siteInfo) {
            throw new Exception('uuid invalid');
        }
        set_current_site(SiteInfoDto::from($siteInfo));

        return $handler->handle($request);
    }

    protected function ignore(ServerRequestInterface $request): bool
    {
        $uri = $request->getUri();
        var_dump("Current uri: $uri");
        if ($uri->getPath() !== '/favicon.ico' && mb_substr_count($uri->getPath(), '/') > 1) {
            [$empty, $moduleName, $controllerName] = explode('/', $uri->getPath());
            if (in_array($moduleName, ['swagger'])) {
                return true;
            }
            if ($moduleName === 'openWechat' && $controllerName === 'callback') {
                return true;
            }
            return false;
        }
        return true;
    }
}
