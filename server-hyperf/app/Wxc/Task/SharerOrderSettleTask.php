<?php
declare(strict_types=1);

namespace App\Wxc\Task;

use Hyperf\Crontab\Annotation\Crontab;

/**
 * 分享员订单结算，将分账金额入账
 */
#[Crontab(name: "SharerOrderSettleTask", rule: "* * * * *", memo: "分享员订单结算，将分账金额入账")]
class SharerOrderSettleTask
{
    public function execute()
    {
        // todo 自动结算，前提是要求订单完成/收货7天后，为了避免售后纠纷
    }
}