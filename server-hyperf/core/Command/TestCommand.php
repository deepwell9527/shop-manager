<?php

declare(strict_types=1);

namespace Deepwell\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;

#[Command]
class TestCommand extends HyperfCommand
{
    protected ?string $name = 'app:test';

    public function handle()
    {

    }
}