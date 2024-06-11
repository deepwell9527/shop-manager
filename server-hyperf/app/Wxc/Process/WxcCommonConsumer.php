<?php
declare(strict_types=1);

namespace App\Wxc\Process;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;

/**
 * 常规队列
 */
#[Process(name: 'queue.wxc_common')]
class WxcCommonConsumer extends ConsumerProcess
{
    protected string $queue = 'wxc_common';
}