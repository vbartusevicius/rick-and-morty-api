<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Episode;
use App\Entity\User;
use App\Entity\WatchedEpisode;
use App\Enum\EpisodeRatingEnum;
use App\Enum\UserGenderEnum;
use DataFixtures\Helper\CsvHelper;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const USER_REF = 'user_';

    private array $ratings = [
        EpisodeRatingEnum::Awesome,
        EpisodeRatingEnum::SoSo,
        EpisodeRatingEnum::Meh,
    ];

    private array $genders = [
        UserGenderEnum::Female,
        UserGenderEnum::Male,
        UserGenderEnum::Intersex,
        UserGenderEnum::NonBinary,
        UserGenderEnum::Trans,
        null,
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/users.csv', ',') as $row) {
            $user = new User();

            $watchedEpisodes = [];
            if ($row['episodes'] !== null) {
                $watchedEpisodes = $this->getWatchedEpisodes($manager, $row['episodes']);
            }

            $user
                ->setName($row['name'])
                ->setRegisteredAt(new DateTimeImmutable(sprintf('-%s day', mt_rand(1, 100))))
                ->setGender($this->genders[array_rand($this->genders, 1)])
                ->setWatchedEpisodes($watchedEpisodes)
            ;

            $manager->persist($user);
            $this->addReference(self::USER_REF . $row['id'], $user);
        }

        $manager->flush();
    }

    /**
     * @return Episode[]
     */
    private function getWatchedEpisodes(ObjectManager $manager, string $episodesList): array
    {
        $episodes = array_map(
            function (string $item) {
                return $this->getReference(EpisodeFixtures::EPISODE_REF . $item);
            },
            explode(',', $episodesList)
        );

        $list = [];
        foreach ($episodes as $episode) {
            $watchedEpisode = new WatchedEpisode();
            $watchedEpisode
                ->setEpisode($episode)
                ->setRating($this->ratings[array_rand($this->ratings, 1)])
            ;
            $manager->persist($watchedEpisode);
            $list[] = $watchedEpisode;
        }

        return $list;
    }

    public function getDependencies(): array
    {
        return [
            EpisodeFixtures::class,
        ];
    }
}
