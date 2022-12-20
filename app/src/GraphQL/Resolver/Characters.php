<?php

namespace App\GraphQL\Resolver;

use App\Repository\CharacterRepository;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class Characters implements QueryInterface
{

    public function __construct(private readonly CharacterRepository $repository)
    {

    }

    public function __invoke($limit)
    {
        return $this->repository->findBy([], null, $limit);
    }
}