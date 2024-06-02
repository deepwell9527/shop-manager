<?php

use App\Site\Dto\SiteInfoDto;
use Hyperf\Context\Context;

function set_current_site(SiteInfoDto $siteInfo): void
{
    Context::set('current_site_info', $siteInfo);
}

function get_current_site():?SiteInfoDto
{
    return Context::get('current_site_info');
}