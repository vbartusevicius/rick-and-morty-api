<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class User
{
    private int $id;
    private string $name;
    private iterable $watchedEpisodes;

    public function __construct()
    {
        $this->watchedEpisodes = new ArrayCollection();
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
}
