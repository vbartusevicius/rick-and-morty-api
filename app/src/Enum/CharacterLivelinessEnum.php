<?php

declare(strict_types=1);

namespace App\Enum;

enum CharacterLivelinessEnum: string
{
    case Alive = 'Alive';
    case Dead = 'Dead';
}
