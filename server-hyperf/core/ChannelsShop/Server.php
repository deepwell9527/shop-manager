<?php

declare(strict_types=1);

namespace Deepwell\ChannelsShop;

use EasyWeChat\Kernel\Encryptor;
use Psr\Http\Message\ServerRequestInterface;

class Server extends \EasyWeChat\OfficialAccount\Server
{
    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function setEncryptor(?Encryptor $encryptor): void
    {
        $this->encryptor = $encryptor;
    }
}
