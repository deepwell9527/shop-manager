<?php

declare(strict_types=1);

use Hyperf\AsyncQueue\Process\ConsumerProcess;

return [
    Hyperf\Crontab\Process\CrontabDispatcherProcess::class,
    ConsumerProcess::class
];
