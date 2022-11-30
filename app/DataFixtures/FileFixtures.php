<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\File\File;
use App\Entity\File\Image;
use App\Enum\File\FileProviderEnum;
use DataFixtures\Helper\CsvHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FileFixtures extends Fixture implements OrderedFixtureInterface
{
    public const FILE_REF = 'file_';

    public function load(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/characters.csv', "\t") as $row) {
            $file = new File();
            $file
                ->setProvider(FileProviderEnum::Image)
            ;
            $image = new Image();
            $image
                ->setFile($file)
                ->setUrl(sprintf('https://rickandmortyapi.com/api/character/avatar/%s.jpeg', $row['id']))
            ;

            $manager->persist($file);
            $manager->persist($image);
            $this->addReference(self::FILE_REF . $row['id'], $file);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
