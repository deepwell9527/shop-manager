<?php

declare(strict_types=1);

namespace Deepwell\Concern;

use Deepwell\Contract\QueryInputInterface;

/**
 * 查询服务
 */
trait QueryService
{
    /**
     * 获取一条记录
     */
    public function getOne(QueryInputInterface $input)
    {
        $data = $input->toQuery($this->queryModelClassName::query())->first();
        // 为了返回值提示用
        if ($data instanceof $this->queryModelClassName) {
            return $data;
        }
        return null;
    }
}