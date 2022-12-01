<?php

declare(strict_types=1);

namespace App\Feature\File\Provider;

use App\Feature\File\DTO\FileContents;
use App\Feature\File\Entity\File;
use Exception;
use Traversable;

class FileContentsProvider
{
    /**
     * @var FileContentsProviderInterface[]
     */
    private array $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = $providers instanceof Traversable ? iterator_to_array($providers) : $providers;
    }

    public function getFileContents(File $file): ?FileContents
    {
        try {
            return $this->providers[$file->getProvider()->value]->buildFileContents($file);
        } catch (Exception) {
            return null;
        }
    }
}
