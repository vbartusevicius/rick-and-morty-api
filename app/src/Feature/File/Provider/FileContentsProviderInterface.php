<?php

declare(strict_types=1);

namespace App\Feature\File\Provider;

use App\Feature\File\DTO\FileContents;
use App\Feature\File\Entity\File;

interface FileContentsProviderInterface
{
    public function buildFileContents(File $file): FileContents;
}
