<?php

declare(strict_types=1);

namespace App\Feature\File\Repository;

use App\Feature\File\Entity\File;
use App\Feature\File\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function findOneByFile(File $file): ?Image
    {
        return $this->createQueryBuilder('i')
            ->where('i.file = :file')
            ->setParameters([
                'file' => $file,
            ])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
