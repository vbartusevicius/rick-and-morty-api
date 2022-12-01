<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\UserGenderEnum;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    private int $id;
    private string $name;
    private iterable $watchedEpisodes;
    private DateTimeImmutable $registeredAt;
    private ?UserGenderEnum $gender;

    public function __construct()
    {
        $this->watchedEpisodes = new ArrayCollection();
        $this->registeredAt = new DateTimeImmutable();
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

    /**
     * @return WatchedEpisode[]
     */
    public function getWatchedEpisodes(): iterable
    {
        return $this->watchedEpisodes;
    }

    /**
     * @param WatchedEpisode[] $watchedEpisodes
     */
    public function setWatchedEpisodes(iterable $watchedEpisodes): self
    {
        foreach ($this->watchedEpisodes as $watchedEpisode) {
            $this->removeEpisode($watchedEpisode);
        }
        foreach ($watchedEpisodes as $watchedEpisode) {
            $this->addWatchedEpisode($watchedEpisode);
        }
        return $this;
    }

    public function addWatchedEpisode(WatchedEpisode $episode): self
    {
        if (!$this->watchedEpisodes->contains($episode)) {
            $this->watchedEpisodes->add($episode);
            $episode->setUser($this);
        }

        return $this;
    }

    public function removeEpisode(WatchedEpisode $episode): self
    {
        if ($this->watchedEpisodes->contains($episode)) {
            $this->watchedEpisodes->removeElement($episode);
            $episode->removeUser();

        }
        return $this;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;
        return $this;
    }

    public function getGender(): ?UserGenderEnum
    {
        return $this->gender;
    }

    public function setGender(?UserGenderEnum $gender): self
    {
        $this->gender = $gender;
        return $this;
    }
}
