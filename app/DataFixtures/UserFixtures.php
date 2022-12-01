<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Entity\User;
use App\Entity\WatchedEpisode;
use App\Enum\EpisodeRatingEnum;
use DataFixtures\Helper\CsvHelper;
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

    public function load(ObjectManager $manager): void
    {
        foreach (CsvHelper::readRow(__DIR__ . '/fixtures/users.csv', ',') as $row) {
            $user = new User();

            $episodes = [];
            if ($row['episodes'] !== null) {
                $episodes = array_map(
                    function (string $item) {
                        return $this->getReference(EpisodeFixtures::EPISODE_REF . $item);
                    },
                    explode(',', $row['episodes'])
                );
            }
            foreach ($episodes as $episode) {
                $watchedEpisode = new WatchedEpisode();
                $watchedEpisode
                    ->setUser($user)
                    ->setEpisode($episode)
                    ->setRating($this->ratings[array_rand($this->ratings, 1)])
                ;
                $manager->persist($watchedEpisode);

                $user->addWatchedEpisode($watchedEpisode);
            }

            $user
                ->setName($row['name'])
            ;

            $manager->persist($user);
            $this->addReference(self::USER_REF . $row['id'], $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EpisodeFixtures::class,
        ];
    }
}
