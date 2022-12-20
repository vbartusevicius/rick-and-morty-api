<?php

namespace App\GraphQL\Resolver;

use App\Entity\User;
use App\Repository\EpisodeRepository;
use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;
use Symfony\Component\Runtime\ResolverInterface;

class Episodes implements QueryInterface
{

    public function __construct(private readonly EpisodeRepository $repository)
    {

    }

    public function __invoke($limit)
    {
        return $this->repository->findBy([],null,$limit);
    }
}