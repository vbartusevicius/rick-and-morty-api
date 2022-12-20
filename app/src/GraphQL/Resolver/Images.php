<?php

namespace App\GraphQL\Resolver;

use App\Feature\File\Provider\ImageProvider;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class Images implements QueryInterface
{

    public function __construct(private readonly ImageProvider $imageProvider)
    {

    }

    public function __invoke($context, ResolveInfo $info, $size)
    {
        return $this->imageProvider->buildFileContents();
    }
}