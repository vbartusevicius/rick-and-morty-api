<?php

declare(strict_types=1);

namespace App\Feature\File\Enum;

enum FileContentDeliveryEnum: string
{
    case Inline = 'inline';
    case Resource = 'resource';
}
