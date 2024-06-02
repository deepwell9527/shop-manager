<?php

declare(strict_types=1);


namespace App\OpenWechat\Mapper;

use App\OpenWechat\Model\CallbackRecord;
use Mine\Abstracts\AbstractMapper;

class CallbackRecordMapper extends AbstractMapper
{
    /**
     * @var CallbackRecord
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = CallbackRecord::class;
    }
}
