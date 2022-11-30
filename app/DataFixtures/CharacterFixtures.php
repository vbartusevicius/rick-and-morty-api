<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Character;
use App\Enum\CharacterGenderEnum;
use App\Enum\CharacterLivelinessEnum;
use App\Enum\CharacterSpeciesEnum;
use DataFixtures\Helper\CsvHelper;
use DataFixtures\Helper\ReflectionHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use OutOfBoundsException;

class CharacterFixtures extends Fixture implements OrderedFixtureInterface
{
    public const CHARACTER_REF = 'character_';

    public function load(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/characters.csv', "\t") as $row) {
            $character = new Character();

            $origin = null;
            if ($row['origin'] !== null) {
                try {
                    $origin = $this->getReference(LocationFixtures::LOCATION_REF . $row['origin']);
                } catch (OutOfBoundsException) {
                    // nothing
                }
            }
            $location = null;
            if ($row['location'] !== null) {
                try {
                    $location = $this->getReference(LocationFixtures::LOCATION_REF . $row['location']);
                } catch (OutOfBoundsException) {
                    // nothing
                }
            }
            $appearsIn = [];
            if ($row['episode'] !== null) {
                $appearsIn = array_map(
                    function ($id) {
                        return $this->getReference(EpisodeFixtures::EPISODE_REF . $id);
                    },
                    explode(',', $row['episode'])
                );
            }

            $character
                ->setName($row['name'])
                ->setStatus(CharacterLivelinessEnum::tryFrom($row['status']))
                ->setSpecies(CharacterSpeciesEnum::tryFrom($row['species']))
                ->setDescription($row['type'])
                ->setGender(CharacterGenderEnum::tryFrom($row['gender']))
                ->setOrigin($origin)
                ->setLocation($location)
                ->setAppearsIn($appearsIn)
                ->setImage($this->getReference(FileFixtures::FILE_REF . $row['id']))
            ;

            ReflectionHelper::setId($character, (int) $row['id']);

            $manager->persist($character);
            $this->addReference(self::CHARACTER_REF . $character->getId(), $character);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
