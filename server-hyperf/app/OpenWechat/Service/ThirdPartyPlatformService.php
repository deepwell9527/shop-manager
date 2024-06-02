<?php
declare(strict_types=1);

namespace App\OpenWechat\Service;

use App\OpenWechat\Mapper\AuthorizerMapper;
use Closure;
use EasyWeChat\OpenPlatform\Application;
use EasyWeChat\OpenPlatform\Message;
use EasyWeChat\OpenPlatform\Server;
use Exception;
use Hyperf\Config\Annotation\Value;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\SimpleCache\CacheInterface;
use function is_callable;

class ThirdPartyPlatformService
{
    #[Value('open_wechat.third_party_platform')]
    protected array $config;

    protected Application $application;

    public function __construct()
    {
        $this->application = $this->makeApplication();
    }

    protected function makeApplication()
    {
        $app = make(Application::class, [$this->config]);
        $cache = container()->get(CacheInterface::class);
        $app->setCache($cache);
        return $app;
    }

    public function serve(RequestInterface $request)
    {
        $this->application->setRequest($request);
        $this->setServer();
        $server = $this->application->getServer();
        return $server->serve();
    }

    protected function setServer(): void
    {
        $server = new Server(
            encryptor: $this->application->getEncryptor(),
            request: $this->application->getRequest()
        );
        $server->withDefaultVerifyTicketHandler(
            function (Message $message, Closure $next): mixed {
                $ticket = $this->application->getVerifyTicket();
                if (is_callable([$ticket, 'setTicket'])) {
                    $ticket->setTicket($message->ComponentVerifyTicket);
                }

                return $next($message);
            }
        );

        $this->application->setServer($server);
    }

    public function genPreAuthUrl(): string
    {
        $app = $this->getApplication();
        $callbackUrl = env('OPEN_WECHAT_AUTHORIZE_CALLBACK_URL') . '?uuid=' . get_current_site()['uuid'] ?? '';
        return $app->createPreAuthorizationUrl($callbackUrl, [
            'auth_type' => 2,
        ]);
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function saveAuthorizeCallbackInfo(string $authCode)
    {
        $authorization = $this->getApplication()->getAuthorization($authCode);

        $authorizerMapper = container()->get(AuthorizerMapper::class);

        //
        $exist = $authorizerMapper->first([
            'app_id' => $authorization->getAppId(),
        ]);
        if ($exist->site_id != get_current_site()['site_id']) {
            throw new Exception('已在其他站点授权，请先解绑');
        }

        return $authorizerMapper->save([
            'app_id' => $authorization->getAppId(),
            'site_id' => get_current_site()['site_id'],
            'access_token' => $authorization->getAccessToken(),
            'expire_at' => time() + 7200,
            'refresh_token' => $authorization->getRefreshToken(),
        ]);
    }
}