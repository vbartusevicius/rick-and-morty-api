<?php

declare(strict_types=1);

namespace App\Feature\File\Provider;

use App\Feature\File\DTO\FileContents;
use App\Feature\File\Entity\File;
use App\Feature\File\Enum\FileContentDeliveryEnum;
use App\Exception\ImageNotFoundException;
use App\Feature\File\Repository\ImageRepository;

class ImageProvider implements FileContentsProviderInterface
{
    private ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function buildFileContents(File $file): FileContents
    {
        $image = $this->imageRepository->findOneByFile($file);

        if ($image === null) {
            throw new ImageNotFoundException(sprintf('Image not found by File:%s', $file->getId()));
        }

        return new FileContents(FileContentDeliveryEnum::Resource, $image->getUrl());
    }
}
