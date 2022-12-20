<?php

declare(strict_types=1);

namespace App\GraphQL\Loader;

use App\Repository\WatchedEpisodeRepository;
use Overblog\PromiseAdapter\PromiseAdapterInterface;

class WatchedEpisodesLoader
{
    public function __construct(
        private readonly WatchedEpisodeRepository $repository,
        private readonly PromiseAdapterInterface $promiseAdapter
    ) {

    }

    public function all(array $list)
    {
        $qb = $this->repository->createQueryBuilder('we');
        $orStatements = [];
        foreach ($list as $key => $item) {
            $userId = $item['user_id'];
            $episodeId = $item['episode_id'];

            $orStatements[] = $qb->expr()->andX(
                'we.user = :user_' . $key,
                'we.episode = :episode_' . $key
            );
            $qb->setParameter('user_' . $key, $userId);
            $qb->setParameter('episode_' . $key, $episodeId);
        }

        $result = $qb
            ->where($qb->expr()->orX(...$orStatements))
            ->getQuery()
            ->getResult()
        ;

        return $this->promiseAdapter->createAll(array_pad($result, count($list), null));
    }
}
