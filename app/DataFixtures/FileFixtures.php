<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Feature\File\Entity\File;
use App\Feature\File\Entity\Image;
use App\Feature\File\Enum\FileProviderEnum;
use DataFixtures\Helper\CsvHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FileFixtures extends Fixture
{
    public const CHARACTER_FILE_REF = 'character_file_';
    public const EPISODE_FILE_REF = 'episode_file_';

    public function load(ObjectManager $manager): void
    {
        $this->loadCharacterFiles($manager);
        $this->loadEpisodeFiles($manager);

        $manager->flush();
    }

    private function loadCharacterFiles(ObjectManager $manager): void
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
            $this->addReference(self::CHARACTER_FILE_REF . $row['id'], $file);
        }
    }

    private function loadEpisodeFiles(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/episodes.csv', "\t") as $row) {
            $file = new File();
            $file
                ->setProvider(FileProviderEnum::Image)
            ;

            $image = new Image();
            $image
                ->setFile($file)
                ->setUrl(sprintf('https://cataas.com/cat?t=%s', $row['id']))
            ;

            $manager->persist($file);
            $manager->persist($image);
            $this->addReference(self::EPISODE_FILE_REF . $row['id'], $file);
        }
    }
}
