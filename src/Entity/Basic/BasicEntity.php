<?php

namespace App\Entity\Basic;

use Doctrine\ORM\Mapping as ORM;

class BasicEntity
{
    /**
     * @ORM\Column(type="integer")
     *
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $updatedAt;

}
