<?php
declare(strict_types=1);

namespace Deepwell\Data\Listeners;

use Deepwell\Data\Support\DataConfig;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;

#[Listener]
class InitDataConfigListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    public function process(object $event): void
    {
        $container = container();
        $dataCfg = DataConfig::createFromConfig(config('data'));
        $container->set(DataConfig::class, $dataCfg);
    }
}