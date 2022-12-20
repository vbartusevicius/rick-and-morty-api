<?php

namespace App\GraphQL\Resolver;

use App\Entity\Episode;
use App\Feature\File\Entity\File;
use App\Feature\File\Provider\ImageProvider;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

class Images implements QueryInterface
{
    public function __construct(private readonly ImageProvider $imageProvider)
    {

    }

    public function __invoke($size, File $value)
    {
        return $this->imageProvider->buildFileContents($value);
    }
}