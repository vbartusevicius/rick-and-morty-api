<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use App\Enum\File\FileContentDeliveryEnum;

class FileContents
{
    private FileContentDeliveryEnum $contentDelivery;
    private string $contents;

    public function __construct(FileContentDeliveryEnum $contentDelivery, string $contents)
    {
        $this->contentDelivery = $contentDelivery;
        $this->contents = $contents;
    }

    public function getContentDelivery(): FileContentDeliveryEnum
    {
        return $this->contentDelivery;
    }

    public function getContents(): string
    {
        return $this->contents;
    }
}
