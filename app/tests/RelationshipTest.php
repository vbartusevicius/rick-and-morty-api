<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Episode;
use App\Entity\WatchedEpisode;
use App\Enum\CharacterGenderEnum;
use App\Enum\CharacterSpeciesEnum;
use App\Enum\EpisodeRatingEnum;
use App\Repository\CharacterRepository;
use App\Repository\EpisodeRepository;
use App\Repository\UserRepository;
use DataFixtures\CharacterFixtures;
use DataFixtures\EpisodeFixtures;
use DataFixtures\FileFixtures;
use DataFixtures\LocationFixtures;
use DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RelationshipTest extends KernelTestCase
{
    private CharacterRepository $characterRepository;
    private EpisodeRepository $episodeRepository;
    private UserRepository $userRepository;

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        $databaseTool = $container->get(DatabaseToolCollection::class)->get();

        $this->characterRepository = $container->get(CharacterRepository::class);
        $this->episodeRepository = $container->get(EpisodeRepository::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->entityManager = $container->get('doctrine.orm.entity_manager');

        $databaseTool->loadFixtures([
            CharacterFixtures::class,
            EpisodeFixtures::class,
            FileFixtures::class,
            LocationFixtures::class,
            UserFixtures::class,
        ]);
    }

    public function testCharacterHoldsRelations()
    {
        $character = $this->characterRepository->find(7);

        $this->assertInstanceOf(CharacterSpeciesEnum::class, $character->getSpecies());
        $this->assertInstanceOf(CharacterGenderEnum::class, $character->getGender());
        $this->assertNotNull($character->getDescription());
        $this->assertNull($character->getStatus());

        $this->assertEquals('Earth (Replacement Dimension)', $character->getOrigin()->getName());
        $this->assertEquals('Testicle Monster Dimension', $character->getLocation()->getName());
        $this->assertCount(2, $character->getAppearsIn());

        foreach ($character->getAppearsIn() as $item) {
            $this->assertContains($item->getName(), ['Close Rick-counters of the Rick Kind', 'Ricksy Business']);
        }
    }

    public function testWatchedEpisodesAddedToCollection()
    {
        $user = $this->userRepository->find(1);
        $watchedEpisodes = $user->getWatchedEpisodes();

        $this->assertCount(4, $watchedEpisodes);
        foreach ($watchedEpisodes as $watchedEpisode) {
            $this->assertInstanceOf(Episode::class, $watchedEpisode->getEpisode());
            $this->assertInstanceOf(EpisodeRatingEnum::class, $watchedEpisode->getRating());
        }

        $watchedEpisode = new WatchedEpisode();
        $watchedEpisode
            ->setUser($user)
            ->setEpisode($this->episodeRepository->find(30))
            ->setRating(EpisodeRatingEnum::Awesome)
        ;
        $user->addWatchedEpisode($watchedEpisode);

        $this->entityManager->persist($watchedEpisode);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $user = $this->userRepository->find(1);
        $watchedEpisodes = $user->getWatchedEpisodes();
        $this->assertCount(5, $watchedEpisodes);
    }

    public function testWatchedEpisodesEmptyArray()
    {
        $user = $this->userRepository->find(3);
        $watchedEpisodes = $user->getWatchedEpisodes();

        $this->assertCount(0, $watchedEpisodes);
    }
}
