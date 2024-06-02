<?php

namespace HyperfTests\Cases;

use HyperfTests\HttpTestCase;

class OverwriteSQLTest extends HttpTestCase
{
    public function testConnAppendValues()
    {
        $bindings = [
            'superAdmin',
            1000,
            '未知',
            'Windows 10',
            'Chrome',
            1,
            '登录成功',
            '2024-04-05 04:54:18',
            'superAdmin',
            1000,
            '未知',
            'Windows 10',
            'Chrome',
            1,
            '登录成功',
            '2024-04-05 04:54:18'
        ];
        $info = [
            'original_field_count' => 8,
            'append_values' => [
                1000,
            ],
        ];
        if (!empty($info)) {
            $chunks = array_chunk($bindings,8);
            $newList = [];
            foreach ($chunks as $chunk) {
                array_push($newList,...$chunk,...$info['append_values']);
            }
            var_dump($newList);
        }
    }
}