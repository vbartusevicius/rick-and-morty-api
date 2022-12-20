<?php

namespace App\GraphQL\Resolver;

use App\Entity\Episode;
use App\Entity\WatchedEpisode;
use App\Repository\UserRepository;
use Overblog\DataLoader\DataLoader;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class Rating implements QueryInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private DataLoader $loader
    ) {

    }

    public function __invoke(\ArrayObject $context, Episode $episode)
    {
        $user = $this->userRepository->findAll()[0];

        return $this->loader->load(['user_id' => $user->getId(), 'episode_id' => $episode->getId()])
            ->then(
                function (?WatchedEpisode $watchedEpisode) {
                    return $watchedEpisode?->getRating()->value;
                }
            );
    }
}