<?php

namespace Deepwell\ChannelsShop\Api\Basic\Enums;

enum ShopStatus: string
{
    case Opening = 'opening';
    case OpenFinished = 'open_finished';
    case Closing = 'closing';
    case CloseFinished = 'close_finished';
}
