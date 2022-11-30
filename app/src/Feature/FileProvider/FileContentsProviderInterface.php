<?php

declare(strict_types=1);

namespace App\Feature\FileProvider;

use App\Entity\DTO\FileContents;
use App\Entity\File\File;

interface FileContentsProviderInterface
{
    public function buildFileContents(File $file): FileContents;
}
