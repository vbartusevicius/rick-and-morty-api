<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Episode;
use DataFixtures\Helper\CsvHelper;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture
{
    public const EPISODE_REF = 'episode_';

    public function load(ObjectManager $manager): void
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
            ;

            $manager->persist($episode);
            $this->addReference(self::EPISODE_REF . $row['id'], $episode);
            $lastEpisode = $episode;
        }

        $lastEpisode->setAiredAt(new DateTimeImmutable('+1 week 00:00:00'));

        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/episode_descriptions.csv', ',') as $item) {
            /** @var Episode $episode */
            $episode = $this->getReference(self::EPISODE_REF . $item['id']);
            $episode->setDescription($item['description']);
        }

        $manager->flush();
    }
}
