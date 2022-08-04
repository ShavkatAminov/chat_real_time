<?php

namespace App\Entity\Basic;

use Doctrine\ORM\Mapping as ORM;

class BasicEntity
{
    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    /**
     * @param int $updatedAt
     */
    public function setUpdatedAt(int $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @ORM\Column(type="integer", nullable=true, name="created_at")
     *
     */
    protected ?int $createdAt = null;

    /**
     * @ORM\Column(type="integer", name="updated_at")
     *
     */
    protected ?int $updatedAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(time());
        if ($this->createdAt == null) {
            $this->setCreatedAt(time());
        }
    }

}
