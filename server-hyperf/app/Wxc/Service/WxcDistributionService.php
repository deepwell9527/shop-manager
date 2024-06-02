<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Enums\DistributionType;
use App\Wxc\Mapper\WxcDistributionMapper;
use App\Wxc\Request\WxcDistributionSaveRequest;
use Mine\Abstracts\AbstractService;

/**
 * 分销设置服务类
 */
class WxcDistributionService extends AbstractService
{
    /**
     * @var WxcDistributionMapper
     */
    public $mapper;

    public function __construct(WxcDistributionMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function saveSettings(WxcDistributionSaveRequest $data)
    {
        $setting = $this->mapper->first([]);
        if (!$setting) {
            // 默认设置
            $info = [
                'type' => DistributionType::FirstTier->value,
                'auto_upgrade' => false,
            ];
            $info = array_merge($info, $data->toArray());
            return $this->save($info);
        } else {
            return $this->update($setting->id, $data->toArray());
        }
    }
}