<?php

namespace App\GraphQL\Resolver;

use App\Entity\Episode;
use App\Entity\WatchedEpisode;
use App\Feature\File\Entity\File;
use App\Feature\File\Provider\ImageProvider;
use App\Repository\UserRepository;
use App\Repository\WatchedEpisodeRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class Rating implements QueryInterface
{
    public function __construct(
        private readonly WatchedEpisodeRepository $repository,
        private readonly UserRepository $userRepository
    )
    {

    }

    public function __invoke(\ArrayObject $context, Episode $episode)
    {
        /** @var WatchedEpisode $watchedEpisode */
        if ($context->offsetExists('watchedEpisode_' . $episode->getId())) {
            if (null !== $context->offsetGet('watchedEpisode_' . $episode->getId())) {
                return $context->offsetGet('watchedEpisode_' . $episode->getId())->getRating()->value;
            }
        }

        $watchedEpisode = $this->repository->findOneBy([
            'episode' => $episode,
            'user' => $this->userRepository->findAll()[0],
        ]);
        $context->offsetSet('watchedEpisode_' . $episode->getId(), $watchedEpisode);

        return $watchedEpisode->getRating()->value;
    }
}