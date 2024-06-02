<?php
declare(strict_types=1);

namespace App\Site\Service;

use App\Site\Mapper\SiteInfoMapper;
use App\Site\Model\SiteInfo;
use Hyperf\Di\Annotation\Inject;

class SiteInfoService
{
    #[Inject]
    protected SiteInfoMapper $mapper;

    public function findByUuid(string $uuid): ?SiteInfo
    {
        return $this->mapper->findByUuid($uuid);
    }

    public function findBySiteId(int $siteId): ?SiteInfo
    {
        return $this->mapper->findBySiteId($siteId);
    }
}