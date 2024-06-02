<?php

namespace HyperfTests\Cases;

use App\Setting\Model\SettingCrontab;
use HyperfTests\HttpTestCase;
use Mine\MineModel;

class CrontabTest extends HttpTestCase
{
    public function testCrontabGetCrontabList()
    {
        $data = SettingCrontab::query()
            ->where('status', MineModel::ENABLE)
            ->get(explode(',', 'id,name,type,target,rule,parameter'))->toArray();
        var_dump($data);

        $this->assertGreaterThan(count($data), 0);
    }
}