<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Episode;
use App\Entity\Location;
use DataFixtures\Helper\CsvHelper;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use OutOfBoundsException;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODE_REF = 'episode_';

    public function load(ObjectManager $manager): void
    {
        $lastEpisode = $this->loadEpisodes($manager);
        $lastEpisode->setAiredAt(new DateTimeImmutable('+1 week 00:00:00'));

        $this->loadEpisodeDescriptions();
        $this->loadEpisodeLocations();

        $manager->flush();
    }

    private function loadEpisodes(ObjectManager $manager): Episode
    {
        $lastEpisode = null;

        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/episodes.csv', "\t") as $row) {
            preg_match('/^S(\d{2})E(\d{2})$/', $row['episode'], $matches);
            $episode = new Episode();
            $episode
                ->setName($row['name'])
                ->setAiredAt(DateTimeImmutable::createFromFormat('F j, Y', $row['air_date'])->setTime(0, 0, 0))
                ->setSeasonNumber((int) $matches[1])
                ->setEpisodeNumber((int) $matches[2])
                ->setImage($this->getReference(FileFixtures::EPISODE_FILE_REF . $row['id']))
            ;

            $manager->persist($episode);
            $this->addReference(self::EPISODE_REF . $row['id'], $episode);
            $lastEpisode = $episode;
        }

        return $lastEpisode;
    }

    private function loadEpisodeDescriptions(): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/episode_descriptions.csv', ',') as $item) {
            /** @var Episode $episode */
            $episode = $this->getReference(self::EPISODE_REF . $item['id']);
            $episode->setDescription($item['description']);
        }
    }

    private function loadEpisodeLocations(): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/episode_locations.csv', ',') as $item) {
            /** @var Episode $episode */
            $episode = $this->getReference(self::EPISODE_REF . $item['id']);

            $locations = array_map(
                function (string $id): ?Location {
                    try {
                        return $this->getReference(LocationFixtures::LOCATION_REF . $id);
                    } catch (OutOfBoundsException) {
                        return null;
                    }
                },
                array_unique(explode(' ', $item['location']))
            );

            $episode->setLocations(array_filter($locations));
        }
    }

    public function getDependencies(): array
    {
        return [
            FileFixtures::class,
            LocationFixtures::class,
        ];
    }
}
