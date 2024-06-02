<?php

declare(strict_types=1);

namespace Deepwell\Command;

use Dotenv\Dotenv;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Psr\Container\ContainerInterface;

#[Command]
class MergeDockerEnvCommand extends HyperfCommand
{
    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('shop-manager:merge-docker-env');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('合并docker环境变量到.env 文件');
    }

    public function handle()
    {
        $data = Dotenv::createMutable([BASE_PATH])->safeLoad();
        $new = [];
        foreach ($data as $key => $value) {
            $new[$key] = !empty(getenv($key)) ? getenv($key) : $value;
        }
        $content = implode("\n", array_map(function ($key, $value) {
            return "{$key}={$value}";
        }, array_keys($new), array_values($new)));
        file_put_contents(BASE_PATH . '/.env', $content);
        $this->line('已将docker环境变量合并到.env文件', 'info');
    }
}
