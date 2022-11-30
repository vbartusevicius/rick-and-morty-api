<?php

declare(strict_types=1);

namespace App\Enum\File;

enum FileContentDeliveryEnum: string
{
    case Inline = 'inline';
    case Resource = 'resource';
}
