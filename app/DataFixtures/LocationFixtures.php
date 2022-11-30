<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Location;
use App\Enum\LocationDimensionEnum;
use App\Enum\LocationTypeEnum;
use DataFixtures\Helper\CsvHelper;
use DataFixtures\Helper\ReflectionHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture implements OrderedFixtureInterface
{
    public const LOCATION_REF = 'location_';

    public function load(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/locations.csv', "\t") as $row) {
            $location = new Location();
            $location
                ->setName($row['name'])
                ->setType(LocationTypeEnum::tryFrom($row['type']))
                ->setDimension(LocationDimensionEnum::tryFrom($row['dimension']))
            ;

            ReflectionHelper::setId($location, (int) $row['id']);

            $manager->persist($location);
            $this->addReference(self::LOCATION_REF . $location->getId(), $location);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
