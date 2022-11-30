<?php

declare(strict_types=1);

namespace App\Enum;

enum EpisodeRatingEnum: string
{
    case Awesome = 'awesome';
    case SoSo = 'so_so';
    case Meh = 'meh';
}
