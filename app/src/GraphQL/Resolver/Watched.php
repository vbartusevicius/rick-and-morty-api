<?php

namespace App\GraphQL\Resolver;

use App\Entity\Episode;
use App\Feature\File\Entity\File;
use App\Feature\File\Provider\ImageProvider;
use App\Repository\UserRepository;
use App\Repository\WatchedEpisodeRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class Watched implements QueryInterface
{
    public function __construct(
        private readonly WatchedEpisodeRepository $repository,
        private readonly UserRepository $userRepository
    )
    {

    }

    public function __invoke(\ArrayObject $context, Episode $episode)
    {
        if ($context->offsetExists('watchedEpisode_' . $episode->getId())) {
            if(null !== $context->offsetGet('watchedEpisode_' . $episode->getId())) {
                return true;
            }
        }

        $watchedEpisode = $this->repository->findOneBy([
            'episode' => $episode,
            'user' => $this->userRepository->findAll()[0],
        ]);
        $context->offsetSet('watchedEpisode_' . $episode->getId(), $watchedEpisode);

        return $watchedEpisode !== null;
    }
}