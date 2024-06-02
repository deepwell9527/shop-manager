<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Mapper\WxcSharerLevelMapper;
use App\Wxc\Request\WxcSharerLevelSaveRequest;
use Exception;
use Mine\Abstracts\AbstractService;

/**
 * 等级设置服务类
 */
class WxcSharerLevelService extends AbstractService
{
    /**
     * @var WxcSharerLevelMapper
     */
    public $mapper;

    public function __construct(WxcSharerLevelMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function saveLevel(WxcSharerLevelSaveRequest $data): mixed
    {
        // 根据title判断是否已存在
        $level = $this->mapper->first(['title' => $data->title]);
        if ($level) {
            throw new Exception('等级已存在：' . $data->title);
        }

        $maxLevel = $this->mapper->getMaxLevel();
        if ($maxLevel) {
            $levelId = $maxLevel->level_id + 1;
        } else {
            $levelId = 1;
        }

        $info = $data->toArray();
        $info['level_id'] = $levelId;

        return $this->mapper->save($info);
    }
}