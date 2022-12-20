<?php

namespace App\GraphQL\Resolver;

use App\Entity\User;
use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;
use Symfony\Component\Runtime\ResolverInterface;

class Users implements QueryInterface
{

    public function __construct(private readonly UserRepository $repository)
    {

    }

    public function __invoke(ResolverInterface $resolver)
    {
        return $this->repository->find(1);
    }
}