<?php
declare(strict_types=1);

namespace App\Site\Mapper;

use App\Site\Model\SiteInfo;
use Hyperf\Di\Annotation\Inject;

class SiteInfoMapper
{
    #[Inject]
    protected SiteInfo $model;

    public function findByUuid(string $uuid): ?SiteInfo
    {
        /** @var ?SiteInfo $siteInfo */
        $siteInfo = $this->model->where('uuid', $uuid)->first();
        return $siteInfo;
    }

    public function findBySiteId(int $siteId): ?SiteInfo
    {
        /** @var ?SiteInfo $siteInfo */
        $siteInfo = $this->model->where('site_id', $siteId)->first();
        return $siteInfo;
    }
}