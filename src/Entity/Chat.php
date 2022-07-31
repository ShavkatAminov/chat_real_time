<?php

namespace App\Entity;

use App\Entity\Basic\BasicEntity;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat extends BasicEntity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $first_user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $first_user_last_message_read;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $second_user_last_message_read;

    /**
     * @ORM\Column(type="integer")
     */
    private int $second_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstUser(): ?int
    {
        return $this->first_user;
    }

    public function setFirstUser(int $first_user): self
    {
        $this->first_user = $first_user;

        return $this;
    }

    public function getSecondUser(): ?int
    {
        return $this->second_user;
    }

    public function setSecondUser(int $second_user): self
    {
        $this->second_user = $second_user;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFirstUserLastMessageRead(): ?int
    {
        return $this->first_user_last_message_read;
    }

    /**
     * @param int|null $first_user_last_message_read
     */
    public function setFirstUserLastMessageRead(?int $first_user_last_message_read): void
    {
        $this->first_user_last_message_read = $first_user_last_message_read;
    }

    /**
     * @return int|null
     */
    public function getSecondUserLastMessageRead(): ?int
    {
        return $this->second_user_last_message_read;
    }

    /**
     * @param int|null $second_user_last_message_read
     */
    public function setSecondUserLastMessageRead(?int $second_user_last_message_read): void
    {
        $this->second_user_last_message_read = $second_user_last_message_read;
    }
}
