<?php

declare(strict_types=1);

namespace App\Entity\File;

use App\Enum\File\FileProviderEnum;

class File
{
    private int $id;
    private FileProviderEnum $provider;

    public function getId(): int
    {
        return $this->id;
    }

    public function getProvider(): FileProviderEnum
    {
        return $this->provider;
    }

    public function setProvider(FileProviderEnum $provider): self
    {
        $this->provider = $provider;
        return $this;
    }
}
