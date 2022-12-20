<?php

namespace App\GraphQL\Mutation;

use App\Entity\WatchedEpisode;
use App\Enum\EpisodeRatingEnum;
use App\Repository\EpisodeRepository;
use App\Repository\UserRepository;
use App\Repository\WatchedEpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class AddToWatchedMutation implements MutationInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EpisodeRepository $episodeRepository,
        private readonly UserRepository $userRepository
    )
    {
    }

    public function __invoke(array $input)
    {
        $episode = $this->episodeRepository->find($input['episodeId']);
        $user = $this->userRepository->find(22);

        $watchedEpisode = new WatchedEpisode();
        $watchedEpisode->setEpisode($episode);
        $watchedEpisode->setUser($user);
        $watchedEpisode->setRating(EpisodeRatingEnum::from($input['rating']));

        $this->em->persist($watchedEpisode);
        $this->em->flush();

        return ['additionJobId'=> uniqid()];
    }
}