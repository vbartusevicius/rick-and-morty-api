<?php

namespace App\GraphQL\Resolver;

use App\Entity\User;
use App\Repository\EpisodeRepository;
use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;
use Symfony\Component\Runtime\ResolverInterface;

class Episodes implements QueryInterface
{

    public function __construct(private readonly EpisodeRepository $repository)
    {

    }

    public function __invoke(Argument $args)
    {
        $paginator = new Paginator(function ($offset, $limit) {
            $a = $this->repository->findBy([],null, $limit, $offset);
            return $a;
        });

        return $paginator->auto($args, function() {
            return count($this->repository->findAll());
        });
    }
}