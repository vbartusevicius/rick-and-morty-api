<?php

declare(strict_types=1);

namespace App\Feature\FileProvider;

use App\Entity\DTO\FileContents;
use App\Entity\File\File;
use App\Enum\File\FileContentDeliveryEnum;
use App\Exception\ImageNotFoundException;
use App\Repository\File\ImageRepository;

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
