<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\LocationTypeEnum;
use App\Enum\LocationDimensionEnum;

class Location
{
    private int $id;
    private string $name;
    private ?LocationTypeEnum $type;
    private ?LocationDimensionEnum $dimension;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?LocationTypeEnum
    {
        return $this->type;
    }

    public function setType(?LocationTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getDimension(): ?LocationDimensionEnum
    {
        return $this->dimension;
    }

    public function setDimension(?LocationDimensionEnum $dimension): self
    {
        $this->dimension = $dimension;
        return $this;
    }
}
