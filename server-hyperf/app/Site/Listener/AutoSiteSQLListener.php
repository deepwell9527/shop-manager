<?php
declare(strict_types=1);

namespace App\Site\Listener;

use App\Site\Database\SiteMySQLConnection;
use Hyperf\Database\Connection;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;

class AutoSiteSQLListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(object $event): void
    {
        Connection::resolverFor('mysql', static function ($connection, $database, $prefix, $config) {
            return new SiteMySQLConnection($connection, $database, $prefix, $config);
        });
    }
}