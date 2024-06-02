<?php

namespace App\Wxc\Enums;

/**
 * 分销模式
 */
enum DistributionType: int
{
    /**
     * 一级分销
     */
    case FirstTier = 1;

    /**
     * 二级分销
     */
    case SecTier = 2;
}
