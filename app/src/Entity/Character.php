<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\File\File;
use App\Enum\CharacterGenderEnum;
use App\Enum\CharacterLivelinessEnum;
use App\Enum\CharacterSpeciesEnum;
use Doctrine\Common\Collections\ArrayCollection;

class Character
{
    private int $id;
    private string $name;
    private ?CharacterLivelinessEnum $status;
    private ?CharacterSpeciesEnum $species;
    private ?string $description;
    private ?CharacterGenderEnum $gender;
    private ?Location $origin;
    private ?Location $location;
    private File $image;
    private iterable $appearsIn;

    public function __construct()
    {
        $this->appearsIn = new ArrayCollection();
    }

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

    public function getStatus(): ?CharacterLivelinessEnum
    {
        return $this->status;
    }

    public function setStatus(?CharacterLivelinessEnum $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getSpecies(): ?CharacterSpeciesEnum
    {
        return $this->species;
    }

    public function setSpecies(?CharacterSpeciesEnum $species): self
    {
        $this->species = $species;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getGender(): ?CharacterGenderEnum
    {
        return $this->gender;
    }

    public function setGender(?CharacterGenderEnum $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getOrigin(): ?Location
    {
        return $this->origin;
    }

    public function setOrigin(?Location $origin): self
    {
        $this->origin = $origin;
        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getImage(): File
    {
        return $this->image;
    }

    public function setImage(File $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Episode[]
     */
    public function getAppearsIn(): iterable
    {
        return $this->appearsIn;
    }

    /**
     * @param Episode[] $appearsIn
     */
    public function setAppearsIn(iterable $appearsIn): self
    {
        foreach ($this->appearsIn as $item) {
            $this->removeAppearsIn($item);
        }
        foreach ($appearsIn as $item) {
            $this->addAppearsIn($item);
        }
        return $this;
    }

    public function addAppearsIn(Episode $episode): self
    {
        if (!$this->appearsIn->contains($episode)) {
            $this->appearsIn->add($episode);
            $episode->addCharacter($this);
        }
        return $this;
    }

    public function removeAppearsIn(Episode $episode): self
    {
        if ($this->appearsIn->contains($episode)) {
            $this->appearsIn->removeElement($episode);
            $episode->removeCharacter($this);
        }
        return $this;
    }
}