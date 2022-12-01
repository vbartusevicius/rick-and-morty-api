<?php

declare(strict_types=1);

namespace App\Entity;

use App\Feature\File\Entity\File;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class Episode
{
    private int $id;
    private string $name;
    private DateTimeImmutable $airedAt;
    private int $seasonNumber;
    private int $episodeNumber;
    private string $description;
    private iterable $characters;
    private File $image;
    private iterable $locations;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->locations = new ArrayCollection();
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

    public function getAiredAt(): DateTimeImmutable
    {
        return $this->airedAt;
    }

    public function setAiredAt(DateTimeImmutable $airedAt): self
    {
        $this->airedAt = $airedAt;
        return $this;
    }

    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    public function setSeasonNumber(int $seasonNumber): self
    {
        $this->seasonNumber = $seasonNumber;
        return $this;
    }

    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }

    public function setEpisodeNumber(int $episodeNumber): self
    {
        $this->episodeNumber = $episodeNumber;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Character[]
     */
    public function getCharacters(): iterable
    {
        return $this->characters;
    }

    /**
     * @param Character[] $characters
     */
    public function setCharacters(iterable $characters): self
    {
        foreach ($this->characters as $character) {
            $this->removeCharacter($character);
        }
        foreach ($characters as $character) {
            $this->addCharacter($character);
        }
        return $this;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->addAppearsIn($this);
        }
        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->contains($character)) {
            $this->characters->removeElement($character);
            $character->removeAppearsIn($this);
        }
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
     * @return Location[]
     */
    public function getLocations(): iterable
    {
        return $this->locations;
    }

    /**
     * @param Location[] $locations
     */
    public function setLocations(iterable $locations): self
    {
        foreach ($this->locations as $location) {
            $this->removeLocation($location);
        }
        foreach ($locations as $location) {
            $this->addLocation($location);
        }
        return $this;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
        }
        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
        }
        return $this;
    }
}
