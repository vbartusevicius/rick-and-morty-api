<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EpisodeRatingEnum;

class WatchedEpisode
{
    private int $id;
    private ?User $user;
    private Episode $episode;
    private EpisodeRatingEnum $rating;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        $user->addWatchedEpisode($this);
        return $this;
    }

    public function removeUser(): self
    {
        $this->user = null;
        return $this;
    }

    public function getEpisode(): Episode
    {
        return $this->episode;
    }

    public function setEpisode(Episode $episode): self
    {
        $this->episode = $episode;
        return $this;
    }

    public function getRating(): EpisodeRatingEnum
    {
        return $this->rating;
    }

    public function setRating(EpisodeRatingEnum $rating): self
    {
        $this->rating = $rating;
        return $this;
    }
}
