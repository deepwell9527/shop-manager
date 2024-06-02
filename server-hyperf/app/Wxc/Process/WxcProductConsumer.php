<?php
declare(strict_types=1);

namespace App\Wxc\Process;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;

#[Process(name: 'queue.wxc_ec_product')]
class WxcProductConsumer extends ConsumerProcess
{
    protected string $queue = 'wxc_ec_product';
}