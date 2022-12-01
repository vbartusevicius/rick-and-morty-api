<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Character;
use App\Entity\Episode;
use App\Entity\Location;
use App\Enum\CharacterGenderEnum;
use App\Enum\CharacterLivelinessEnum;
use App\Enum\CharacterSpeciesEnum;
use DataFixtures\Helper\CsvHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use OutOfBoundsException;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    public const CHARACTER_REF = 'character_';

    public function load(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/characters.csv', "\t") as $row) {
            $character = new Character();

            $character
                ->setName($row['name'])
                ->setStatus(CharacterLivelinessEnum::tryFrom($row['status']))
                ->setSpecies(CharacterSpeciesEnum::tryFrom($row['species']))
                ->setDescription($row['type'])
                ->setGender(CharacterGenderEnum::tryFrom($row['gender']))
                ->setOrigin($row['origin'] ? $this->getLocation((int) $row['origin']) : null)
                ->setLocation($row['location'] ? $this->getLocation((int) $row['location']) : null)
                ->setAppearsIn($row['episode'] ? $this->getEpisodes($row['episode']) : [])
                ->setImage($this->getReference(FileFixtures::CHARACTER_FILE_REF . $row['id']))
            ;

            $manager->persist($character);
            $this->addReference(self::CHARACTER_REF . $row['id'], $character);
        }

        $manager->flush();
    }

    private function getLocation(int $id): ?Location
    {
        try {
            return $this->getReference(LocationFixtures::LOCATION_REF . $id);
        } catch (OutOfBoundsException) {
            // nothing
        }

        return null;
    }

    /**
     * @return Episode[]
     */
    private function getEpisodes(string $episodeList): array
    {
        return array_map(
            function ($id) {
                return $this->getReference(EpisodeFixtures::EPISODE_REF . $id);
            },
            explode(',', $episodeList)
        );
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
            EpisodeFixtures::class,
            FileFixtures::class,
        ];
    }
}
